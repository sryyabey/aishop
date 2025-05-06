<?php
namespace Webkul\Card\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Models\Order;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Card\Helpers\WalletApi;
use Webkul\Sales\Transformers\OrderResource;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PaymentController
{
    /**
     * OrderRepository object
     *
     * @var \Webkul\Sales\Repositories\OrderRepository
     */
    protected $orderRepository;

    /**
     * WalletApi object
     *
     * @var \Webkul\Card\Helpers\WalletApi
     */
    protected $walletApi;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Sales\Repositories\OrderRepository  $orderRepository
     * @param  \Webkul\Card\Helpers\WalletApi  $walletApi
     * @return void
     */
    public function __construct(
        OrderRepository $orderRepository,
        WalletApi $walletApi
    ) {
        $this->orderRepository = $orderRepository;
        $this->walletApi = $walletApi;
    }

    public function getPaymentToken()
    {
        // Zorunlu alanlar - API Entegrasyon Bilgileri
        $merchant_id    = env('PAYTR_MERCHAND_ID');
        $merchant_key   = env('PAYTR_MERCHAND_KEY');
        $merchant_salt  = env('PAYTR_MERCHAND_SALT');
        $cart = Cart::getCart();
        $cartItems = $cart->items;
        $totalPrice = $cart->grand_total;
        $customer = $cart->customer;
        $address = $cart->billing_address;

        $product_data = $cartItems->map(function ($item) {
            return [
                $item->name,
                $item->price,
                $item->quantity
            ];
        })->toArray();

        // Müşteri bilgileri
        $email = $customer->email ?? 'misafir@site.com'; // Varsayılan email
                // Müşteri bilgileri kontrolü ve düzenlemesi
        $firstName = trim($customer->name ?? '');
        $lastName = trim($customer->last_name ?? '');
        
        // İsim ve soyisim kontrolü
        if (empty($firstName) && empty($lastName)) {
            $user_name = 'Misafir Kullanıcı';
        } elseif (empty($lastName)) {
            $user_name = $firstName;
        } elseif (empty($firstName)) {
            $user_name = $lastName;
        } else {
            $user_name = $firstName . ' ' . $lastName;
        }
        
        // İsim uzunluğu kontrolü (PayTR için max 100 karakter)
        $user_name = mb_substr($user_name, 0, 100, 'UTF-8');
        
        // Adres bilgileri kontrolü
        if (!$address) {
            session()->flash('error', 'Lütfen fatura adresi giriniz.');
            return redirect()->route('shop.checkout.onepage.index');
        }

        $user_address = $address->address ?? '';
        if (empty($user_address)) {
            session()->flash('error', 'Lütfen geçerli bir adres giriniz.');
            return redirect()->route('shop.checkout.onepage.index');
        }
        
        $user_phone = $address->phone ?? '';
        if (empty($user_phone)) {
            session()->flash('error', 'Lütfen geçerli bir telefon numarası giriniz.');
            return redirect()->route('shop.checkout.onepage.index');
        }

        // Sepet ve ürün kontrolü
        if (!$cartItems || $cartItems->isEmpty()) {
            session()->flash('error', 'Sepetiniz boş.');
            return redirect()->route('shop.checkout.cart.index');
        }

        $payment_amount = (int)($totalPrice * 100);
        if ($payment_amount <= 0) {
            session()->flash('error', 'Geçersiz ödeme tutarı.');
            return redirect()->route('shop.checkout.cart.index');
        }

        // Benzersiz sipariş numarası oluşturma
        $merchant_oid = uniqid($cart->id . '_');
        
        // Ürün verilerinin kontrolü
        $product_data = $cartItems->map(function ($item) {
            return [
                'name' => substr($item->name ?? 'Ürün', 0, 100), // Max 100 karakter
                'price' => (float)($item->price ?? 0),
                'quantity' => (int)($item->quantity ?? 1)
            ];
        })->filter(function ($item) {
            return $item['price'] > 0 && $item['quantity'] > 0;
        })->values()->toArray();

        if (empty($product_data)) {
            session()->flash('error', 'Geçersiz ürün bilgisi.');
            return redirect()->route('shop.checkout.cart.index');
        }

        $user_basket = base64_encode(json_encode($product_data));

        // Cart güncelleme
        $cart->merchand_oid = $merchant_oid;
        $cart->save();
        // try {
        //     $cart->merchand_oid = $merchant_oid;
        //     $cart->save();
        // } catch (\Exception $e) {
        //     Log::error('Cart güncelleme hatası: ' . $e->getMessage());
        //     session()->flash('error', 'Beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.');
        //     return redirect()->route('shop.checkout.cart.index');
        // }

        $merchant_ok_url    = 'https://sollvine.com/paytr_payment_success';
        $merchant_fail_url  = 'https://sollvine.com/paytr_payment_fail';
        //$merchant_fail_url  = 'https://585f4c1240a6c29b44556f448a5431fd.serveo.net/paytr_payment_call';

        //24.133.152.226
        //'https://www.whatismyip.com/'; test mod için
        //
        $user_ip = request()->ip();

        // Diğer zorunlu alanlar
        $timeout_limit   = "30";
        $debug_on        = 1;
        $test_mode       = 0;
        $no_installment  = 0;
        $max_installment = 0;
        $currency        = "TL";

        // Hash oluşturulması
        $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $user_basket . $no_installment . $max_installment . $currency . $test_mode;

        $paytr_token = base64_encode(hash_hmac('sha256', $hash_str . $merchant_salt, $merchant_key, true));

        // POST verileri
        $post_vals = [
            'merchant_id'       => $merchant_id,
            'user_ip'           => $user_ip,
            'merchant_oid'      => $merchant_oid,
            'email'             => $email,
            'payment_amount'    => $payment_amount,
            'paytr_token'       => $paytr_token,
            'user_basket'       => $user_basket,
            'debug_on'          => $debug_on,
            'no_installment'    => $no_installment,
            'max_installment'   => $max_installment,
            'user_name'         => $user_name,
            'user_address'      => $user_address,
            'user_phone'        => $user_phone,
            'merchant_ok_url'   => $merchant_ok_url,
            'merchant_fail_url' => $merchant_fail_url,
            'timeout_limit'     => $timeout_limit,
            'currency'          => $currency,
            'test_mode'         => $test_mode,
        ];



        // Guzzle HTTP Client ile isteği gönder
        $client = new Client();

        try {
            $response = $client->post('https://www.paytr.com/odeme/api/get-token', [
                'form_params' => $post_vals,
                'timeout'     => 20, // İstek için zaman aşımı
                'connect_timeout' => 20, // Bağlantı için zaman aşımı
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            if ($result['status'] == 'success') {
                $token = $result['token'];
            } else {
                die("PAYTR IFRAME failed. reason:" . $result['reason']);
            }
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                die("PAYTR IFRAME connection error. Response: " . $response->getBody()->getContents());
            } else {
                die("PAYTR IFRAME connection error. err:" . $e->getMessage());
            }
        }

        // Token ile birlikte view'e gönder
        return view('card::pay_tr_payment', ['token' => $token]);
    }
    public function paytr_payment_call(Request $request)
    {

        // Gelen tüm POST verisini yakalama
        $post = $request->all();
        //Log::info('PAYTR POST Data:', $post);

        $merchant_key   = env('PAYTR_MERCHAND_KEY');
        $merchant_salt  = env('PAYTR_MERCHAND_SALT');

        $hash = base64_encode(hash_hmac('sha256', $post['merchant_oid'] . $merchant_salt . $post['status'] . $post['total_amount'], $merchant_key, true));

        if ($hash != $post['hash']) {
            return response('PAYTR notification failed: bad hash', 400);
        }

        $cart = \Webkul\Checkout\Models\Cart::where('merchand_oid', $post['merchant_oid'])->first(); // Typo düzeltildi

        if (!$cart) {
            session()->flash('error', trans('shop::app.checkout.cart.empty'));
            return redirect()->route('shop.checkout.onepage.index');
        }

        // Order data'yı oluşturma ve cart_id'yi güncelleme



        if ($post['status'] == 'success') {
            $order_check = Order::where('cart_id',$cart->id)->first();

            if ($order_check){
                if ($order_check->status == 'pending'){
                    $order->status = 'processing';
                    $order->save();
                    echo 'OK';
                    exit();
                }else{
                    echo 'OK';
                    exit();
                }
            }

            $orderData = (new OrderResource($cart))->jsonSerialize();
            $order = $this->orderRepository->create($orderData);
            $order->status = 'processing';
            $order->save();
            Log::info('Order :', $order);

            // OK yanıtı verin
            echo "OK";
            exit;

        } else {
            $order = $this->orderRepository->create($orderData);
            $order->status = 'canceled';
            $order->failed_reason_code = $post['failed_reason_code'];
            $order->failed_reason_msg = $post['failed_reason_msg'];
            $order->save();

            session()->flash('error', trans('shop::app.checkout.payment-failed'));
            return redirect()->route('shop.checkout.onepage.index');
        }


    }

    public function paytr_payment_success()
    {

        //Log::info('PAYTR POST Data:', ['cart' => 'islememler ile gelen']);
        Cart::deActivateCart();

        session()->flash('success', 'Siparişiniz Başarılı Bir Şekide Alındı !');

        return redirect()->route('shop.customers.account.orders.index');
    }

    // fail tarafı ayrı kodlanacak
    public function paytr_payment_fail()
    {
        $cart = Cart::getCart();

        if (!$cart) {
            session()->flash('error', trans('shop::app.checkout.cart.empty'));
            return redirect()->route('shop.checkout.onepage.index');
        }

        $orderData = (new OrderResource($cart))->jsonSerialize();
        $order = $this->orderRepository->create($orderData);
        $order->status = 'canceled';
        $order->failed_reason_code = $post['failed_reason_code'];
        $order->failed_reason_msg = $post['failed_reason_msg'];
        $order->save();

        session()->flash('error', trans('shop::app.checkout.payment-failed'));
        return redirect()->route('shop.checkout.onepage.index');
    }

}
