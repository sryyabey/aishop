<?php

namespace Webkul\PayTR\Payment;

use Webkul\Payment\Payment\Payment;
use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\InvoiceRepository;
use Illuminate\Support\Facades\Log;

class PayTR extends Payment
{
    /**
     * Payment method code
     */
    protected $code = 'paytr';

    /**
     * PayTR API credentials
     */
    protected $merchantId;
    protected $merchantKey;
    protected $merchantSalt;
    protected $testMode;

    /**
     * Repository instances
     */
    protected $orderRepository;
    protected $invoiceRepository;

    /**
     * Create a new instance.
     *
     * @param  \Webkul\Sales\Repositories\OrderRepository  $orderRepository
     * @param  \Webkul\Sales\Repositories\InvoiceRepository  $invoiceRepository
     * @return void
     */
    public function __construct(
        OrderRepository $orderRepository,
        InvoiceRepository $invoiceRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->invoiceRepository = $invoiceRepository;

        $this->merchantId = core()->getConfigData('sales.paymentmethods.paytr.merchant_id');
        $this->merchantKey = core()->getConfigData('sales.paymentmethods.paytr.merchant_key');
        $this->merchantSalt = core()->getConfigData('sales.paymentmethods.paytr.merchant_salt');
        $this->testMode = core()->getConfigData('sales.paymentmethods.paytr.test_mode');
    }

    /**
     * Get redirect URL for PayTR iframe
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return route('paytr.redirect');
    }

    /**
     * Generates PayTR iframe token for payment
     *
     * @param  array  $data
     * @return array
     */
    public function generateToken($orderId)
    {
        $order = $this->orderRepository->find($orderId);

        if (! $order) {
            return ['error' => true, 'message' => 'Sipariş bulunamadı'];
        }

        // User info
        $user_ip = request()->ip();
        $email = $order->customer_email;
        $user_name = $order->customer_first_name . ' ' . $order->customer_last_name;
        $user_address = $order->shipping_address->address1;
        $user_phone = $order->billing_address->phone ?? '';

        // Payment amount (must be multiplied by 100)
        $payment_amount = round($order->grand_total * 100);

        // Set timeout limit 30 minutes
        $timeout_limit = 30;

        // Merchant order id
        $merchant_oid = $order->id;

        // Create hash for token
        $no_installment = 0;
        $max_installment = 0;
        $currency = strtoupper($order->order_currency_code);

        // Prepare products for basket
        $user_basket = [];
        foreach ($order->items as $item) {
            $user_basket[] = [
                $item->name,
                $item->price,
                $item->qty_ordered
            ];
        }
        // Add shipping cost if exists
        if ($order->shipping_amount > 0) {
            $user_basket[] = [
                'Kargo Ücreti',
                $order->shipping_amount,
                1
            ];
        }

        // Convert basket array to JSON and then base64 format
        $user_basket_json = json_encode($user_basket);
        $user_basket_base64 = base64_encode($user_basket_json);

        // Create hash
        $hash_str = $this->merchantId . $user_ip . $merchant_oid . $email . $payment_amount . $user_basket_base64 . $no_installment . $max_installment . $currency . $this->testMode;
        $paytr_token = base64_encode(hash_hmac('sha256', $hash_str . $this->merchantSalt, $this->merchantKey, true));

        $post_vals = [
            'merchant_id' => $this->merchantId,
            'user_ip' => $user_ip,
            'merchant_oid' => $merchant_oid,
            'email' => $email,
            'payment_amount' => $payment_amount,
            'paytr_token' => $paytr_token,
            'user_basket' => $user_basket_base64,
            'debug_on' => 0,
            'no_installment' => $no_installment,
            'max_installment' => $max_installment,
            'user_name' => $user_name,
            'user_address' => $user_address,
            'user_phone' => $user_phone,
            'merchant_ok_url' => route('paytr.success'),
            'merchant_fail_url' => route('paytr.cancel'),
            'timeout_limit' => $timeout_limit,
            'currency' => $currency,
            'test_mode' => $this->testMode,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $result = @curl_exec($ch);

        if (curl_errno($ch)) {
            return ['error' => true, 'message' => 'PAYTR IFRAME bağlantı hatası: ' . curl_error($ch)];
        }

        curl_close($ch);

        $result = json_decode($result, true);

        // If token generation is successful
        if ($result['status'] == 'success') {
            return ['error' => false, 'token' => $result['token']];
        } else {
            return ['error' => true, 'message' => 'PAYTR IFRAME hatası: ' . $result['reason']];
        }
    }

    /**
     * Process PayTR callback
     *
     * @param  array  $data
     * @return bool
     */
    public function processCallback($data)
    {
        // Generate hash for validation
        $hash = base64_encode(hash_hmac('sha256', $data['merchant_oid'] . $this->merchantSalt . $data['status'] . $data['total_amount'], $this->merchantKey, true));

        // Compare hashes
        if ($hash != $data['hash']) {
            Log::error('PayTR callback hash doğrulama hatası.');
            return false;
        }

        // Find order
        $order = $this->orderRepository->findOneWhere(['id' => $data['merchant_oid']]);

        if (! $order) {
            Log::error('PayTR callback: Sipariş bulunamadı - Order ID: ' . $data['merchant_oid']);
            return false;
        }

        try {
            if ($data['status'] == 'success') {
                // Create invoice
                if ($order->canInvoice()) {
                    $invoice = $this->invoiceRepository->create($this->prepareInvoiceData($order));
                    
                    // Update order status to processing
                    $this->orderRepository->update(['status' => 'processing'], $order->id);

                    return true;
                }
            } else {
                // Update order status to payment_failed
                $this->orderRepository->update(['status' => 'payment_failed'], $order->id);
                
                // Log payment error
                Log::error('PayTR ödeme hatası: ' . ($data['failed_reason_code'] ?? 'Bilinmeyen hata'));
            }
        } catch (\Exception $e) {
            Log::error('PayTR callback işleme hatası: ' . $e->getMessage());
            return false;
        }

        return false;
    }

    /**
     * Prepare invoice data.
     *
     * @param  \Webkul\Sales\Models\Order  $order
     * @return array
     */
    protected function prepareInvoiceData($order)
    {
        $invoiceData = [
            'order_id' => $order->id,
            'invoice' => ['items' => []],
        ];

        foreach ($order->items as $item) {
            $invoiceData['invoice']['items'][$item->id] = $item->qty_ordered;
        }

        return $invoiceData;
    }
}