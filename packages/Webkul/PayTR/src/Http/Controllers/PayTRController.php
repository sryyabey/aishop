<?php

namespace Webkul\PayTR\Http\Controllers;

use Illuminate\Http\Request;
use Webkul\Checkout\Facades\Cart as CartFacade;
use Webkul\Customer\Models\Customer;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Transformers\OrderResource;

// Http/Controllers/PayTRController.php

use Illuminate\Routing\Controller;
use Webkul\PayTR\Payment\PayTR;
use Illuminate\Support\Facades\Log;

class PayTRController extends Controller
{
    /**
     * OrderRepository instance
     *
     * @var \Webkul\Sales\Repositories\OrderRepository
     */
    protected $orderRepository; 

    /**
     * PayTR instance
     *
     * @var \Webkul\PayTR\Payment\PayTR
     */
    protected $paytrPayment;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Sales\Repositories\OrderRepository  $orderRepository
     * @param  \Webkul\PayTR\Payment\PayTR  $paytrPayment
     * @return void
     */
    public function __construct(
        OrderRepository $orderRepository,
        PayTR $paytrPayment
    ) {
        $this->orderRepository = $orderRepository;
        $this->paytrPayment = $paytrPayment;
    }
    protected function getAddressLines($address)
    {
        $address = explode(PHP_EOL, $address, 2);

        $addressLines = [current($address)];

        if (isset($address[1])) {
            $addressLines[] = str_replace(["\r\n", "\r", "\n"], ' ', last($address));
        } else {
            $addressLines[] = '';
        }

        return $addressLines;
    }
    /**
     * Redirects to the PayTR payment page
     *
     * @return \Illuminate\View\View
     */
        public function redirect()
    {
        error_reporting(true);
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    
        $cart = CartFacade::collectTotals();
    
        $billingAddress = $cart->getCart()->billing_address;  // getBillingAddressAttribute yerine
        $shippingAddress = $cart->getCart()->shipping_address;  // getShippingAddressAttribute yerine

        if (!$billingAddress || !$shippingAddress) {
            session()->flash('error', trans('checkout::app.no-address-found'));
            return redirect()->route('shop.checkout.cart.index');
        }

        $cart2 = CartFacade::getCart();

        $billingAddressLines = $this->getAddressLines(address: $cart2->billing_address->address);

    
        $orderData = [
            'customer_id' => auth()->guard('customer')->user()->id ?? null,
            'is_guest' => auth()->guard('customer')->check() ? 0 : 1,
            'customer_email' => $billingAddress->email,
            'customer_first_name' => $billingAddress->first_name,
            'customer_last_name' => $billingAddress->last_name,
            'customer_phone' => $billingAddress->phone,
            'customer_type' => 'customer',
            'channel_id' => core()->getCurrentChannel()->id,
            'shipping_method' => $cart->getCart()->selected_shipping_rate->method_title,
            'shipping_title' => $cart->getCart()->selected_shipping_rate->carrier_title,
            'shipping_description' => $cart->getCart()->selected_shipping_rate->method_title,
            'shipping_amount' => $cart->getCart()->selected_shipping_rate->price,
            'base_shipping_amount' => $cart->getCart()->selected_shipping_rate->base_price,
            'grand_total' => $cart->getCart()->grand_total,
            'base_grand_total' => $cart->getCart()->base_grand_total,
            'sub_total' => $cart->getCart()->sub_total,
            'base_sub_total' => $cart->getCart()->base_sub_total,
            'tax_amount' => $cart->getCart()->tax_total,
            'base_tax_amount' => $cart->getCart()->base_tax_total,
            'discount_amount' => $cart->getCart()->discount_amount,
            'base_discount_amount' => $cart->getCart()->base_discount_amount,
            // 'billing_address' => array_merge($billingAddress->toArray(), ['address1' => implode(PHP_EOL, $billingAddress->address)]),
            // 'shipping_address' => array_merge($shippingAddress->toArray(), ['address1' => implode(PHP_EOL, $shippingAddress->address)]),
            // 'cart_items' => $cart->getCart()->items->map(function ($item) {
            //     return [
            //         'product_id' => $item->product_id, 
            //         'sku' => $item->sku,
            //         'name' => $item->name,
            //         'type' => $item->type,
            //         'quantity' => $item->quantity,
            //         'price' => $item->price,
            //         'base_price' => $item->base_price,
            //         'total' => $item->total,
            //         'base_total' => $item->base_total,
            //         'tax_amount' => $item->tax_amount,
            //         'base_tax_amount' => $item->base_tax_amount,
            //         'discount_amount' => $item->discount_amount,
            //         'base_discount_amount' => $item->base_discount_amount,
            //         'additional' => is_array($item->additional) ? $item->additional : []
            //     ];
            // })->toArray()
        ];
    
        $order = $this->orderRepository->create($orderData);
    
        CartFacade::deActivateCart();
    
        $result = $this->paytrPayment->generateToken($order->id);
    
        if ($result['error']) {
            session()->flash('error', $result['message']);
            return redirect()->route('shop.checkout.cart.index');
        }
    
        return view('paytr::shop.iframe', [
            'token' => $result['token']
        ]);
    }
    

    /**
     * Handle success payment
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function success()
    {
        session()->flash('success', trans('paytr::app.payment.success'));
        return redirect()->route('shop.checkout.success');
    }

    /**
     * Handle canceled payment
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel()
    {
        session()->flash('error', trans('paytr::app.payment.canceled'));
        return redirect()->route('shop.checkout.cart.index');
    }

    /**
     * Handle payment notification callback (webhook)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request)
    {
        Log::info('PayTR callback received: ' . json_encode($request->all()));

        $merchantId = core()->getConfigData('sales.paymentmethods.paytr.merchant_id');
        
        if ($request->merchant_id != $merchantId) {
            return response('Unauthorized', 401);
        }

        // Process the callback
        $result = $this->paytrPayment->processCallback($request->all());

        if ($result) {
            return response('OK', 200);
        }

        return response('Failed', 400);
    }
}
