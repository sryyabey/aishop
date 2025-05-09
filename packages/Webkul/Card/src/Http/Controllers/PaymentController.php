<?php
namespace Webkul\Card\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
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
        try {
            // Zorunlu alanlar - API Entegrasyon Bilgileri
            // $merchant_id    = env('PAYTR_MERCHANT_ID');
            // $merchant_key   = env('PAYTR_MERCHANT_KEY');
            // $merchant_salt  = env('PAYTR_MERCHANT_SALT');

            $PAYTR_MERCHANT_ID="570396";
            $PAYTR_MERCHANT_KEY="46JihJUD4NjYwxNu";
            $PAYTR_MERCHANT_SALT="D7Na8UwqwrxuMnw6";
            // Zorunlu alanlar - API Entegrasyon Bilgileri
            $merchant_id    = $PAYTR_MERCHANT_ID;
            $merchant_key   = $PAYTR_MERCHANT_KEY;
            $merchant_salt  = $PAYTR_MERCHANT_SALT;

            $cart = Cart::getCart();
            if (!$cart) {
                Log::error('Cart bulunamadı');
                session()->flash('error', 'Sepetiniz bulunamadı.');
                return redirect()->route('shop.checkout.cart.index');
            }

             // Cart items kontrolü
            $cartItems = $cart->items;
            
            if (!$cartItems || $cartItems->isEmpty()) {
                Log::error('Cart items boş');
                session()->flash('error', 'Sepetinizde ürün bulunmuyor.');
                return redirect()->route('shop.checkout.cart.index');
            }
            // Cart toplam fiyatı
            $totalPrice = $cart->grand_total;

            if ($totalPrice <= 0) {
                Log::error('Geçersiz toplam fiyat: ' . $totalPrice);
                session()->flash('error', 'Geçersiz sipariş tutarı.');
                return redirect()->route('shop.checkout.cart.index');
            }

            // Müşteri ve adres kontrolü
            $customer = $cart->customer;
            $address = $cart->billing_address;
            if (!$address) {
                Log::error('Fatura adresi bulunamadı');
                session()->flash('error', 'Lütfen fatura adresinizi ekleyin.');
                return redirect()->route('shop.checkout.onepage.index');
            }
            // echo "<pre>";
            // print_r(value: $address);
            // echo "</pre>";
            $product_data = $cartItems->map(function ($item) {
                return [
                    $item->name,
                    $item->price,
                    $item->quantity
                ];
            })->toArray(); 

            // Müşteri bilgileri 
            $email = $address->email ?? 'misafir@trendyx.tr'; // Varsayılan email
                    // Müşteri bilgileri kontrolü ve düzenlemesi
            $firstName = trim(string: $address->first_name ?? '');
            $lastName = trim(string: $address->last_name ?? '');
            
            // İsim ve soyisim kontrolü
            if (empty($firstName) && empty($lastName)) {
                $user_name = 'Misafir Kullanıcı';
            }else {
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

            $payment_amount = number_format($totalPrice * 100, 0, '', ''); // Kuruş cinsinden, nokta olmadan
            $user_name = mb_convert_encoding($user_name, 'UTF-8', 'auto');
            $user_address = mb_convert_encoding($user_address, 'UTF-8', 'auto');
            $user_phone = preg_replace('/[^0-9]/', '', $user_phone); // Sadece rakamlar

            // Benzersiz sipariş numarası oluşturma
            $merchant_oid = uniqid($cart->id . '');
            
            // Ürün verilerinin kontrolü
            $product_data = $cartItems->map(function ($item) {
                return [
                    $item->name,  // Ürün adı
                    number_format($item->price, 2, '.', ''),  // Fiyat (örn: 499.00)  
                    $item->quantity  // Adet
                ];
            })->toArray();

            if (empty($product_data)) {
                session()->flash('error', 'Geçersiz ürün bilgisi.');
                return redirect()->route('shop.checkout.cart.index');
            }

            $user_basket = base64_encode(json_encode($product_data));

            // Cart güncelleme
            // $cart->merchant_oid = $merchant_oid;
            // $cart->save(); 
            try {
                $cart->merchant_oid = $merchant_oid;
                $cart->save();
            } catch (\Exception $e) {
                Log::error('Cart güncelleme hatası: ' . $e->getMessage());
                session()->flash('error', 'Beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.');
                return redirect()->route('shop.checkout.cart.index');
            }

            $merchant_ok_url    = 'https://trendyx.tr/paytr_payment_success';
            $merchant_fail_url  = 'https://trendyx.tr/paytr_payment_fail';
            //$merchant_fail_url  = 'https://585f4c1240a6c29b44556f448a5431fd.serveo.net/paytr_payment_call';

            //24.133.152.226
            //'https://www.whatismyip.com/'; test mod için
            //
            $user_ip = request()->ip();

            // Diğer zorunlu alanlar
            $timeout_limit   = "30";
            $debug_on        = 0; 
            $test_mode       = 0;
            $no_installment  = 0;
            $max_installment = 0;
            $currency        = "TL";  

            // Hash oluşturulması
            $hash_str = implode('', [
                $merchant_id,
                $user_ip,
                $merchant_oid,
                $email,
                $payment_amount,
                $user_basket,
                $no_installment,
                $max_installment,
                $currency,
                $test_mode
            ]);
            $paytr_token = base64_encode(hash_hmac('sha256', $hash_str . $merchant_salt, $merchant_key, true));

            // POST verileri
            $post_vals = [
                'merchant_id' => $merchant_id,
                'user_ip' => $user_ip,
                'merchant_oid' => $merchant_oid,
                'email' => $email,
                'payment_amount' => $payment_amount,
                'paytr_token' => $paytr_token,
                'user_basket' => $user_basket,
                'debug_on' => $debug_on,
                'no_installment' => $no_installment,
                'max_installment' => $max_installment,
                'user_name' => $user_name,
                'user_address' => $user_address,
                'user_phone' => $user_phone,
                'merchant_ok_url' => $merchant_ok_url,
                'merchant_fail_url' => $merchant_fail_url,
                'timeout_limit' => $timeout_limit,
                'currency' => $currency,
                'test_mode' => $test_mode,
                'lang' => 'tr'
            ];
            // print_r($post_vals);

        } catch (\Exception $e) {
            Log::error('PayTR token alma hatası: ' . $e->getMessage());
            session()->flash('error', 'Ödeme işlemi başlatılırken bir hata oluştu. Lütfen daha sonra tekrar deneyin.');
            return redirect()->route('shop.checkout.cart.index');
        }
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
        try{
        // Gelen tüm POST verisini yakalama
            $post1 = $request->all();
            $post = json_decode(json_encode($post1), true);
            Log::info('PAYTR POST Data:', $post1);  
            Log::info('PayTR Callback başladı', ['data' => $post]);
            Log::info('PayTR Callback merchant_oid ', ['merchant_oid' => $post['merchant_oid']]);
        
            $PAYTR_MERCHANT_ID="570396"; 
            $PAYTR_MERCHANT_KEY="46JihJUD4NjYwxNu";  
            $PAYTR_MERCHANT_SALT="D7Na8UwqwrxuMnw6";
            // Zorunlu alanlar - API Entegrasyon Bilgileri
            $merchant_id    = $PAYTR_MERCHANT_ID;
            $merchant_key   = $PAYTR_MERCHANT_KEY;
            $merchant_salt  = $PAYTR_MERCHANT_SALT; 

            // $merchant_key   = env('PAYTR_MERCHAND_KEY');
            // $merchant_salt  = env('PAYTR_MERCHAND_SALT');

            $hash_str = $post['merchant_oid'] . $merchant_salt . $post['status'] . $post['total_amount'];
            $hash = base64_encode(hash_hmac('sha256', $hash_str, $merchant_key, true));
            

            // if ($hash != $post['hash']) {
            //     Log::error('PayTR callback hash doğrulama hatası.');
            //     echo 'OK';
            //     exit(); 
            //     // return false;  
            // }
            if ($hash != $post['hash']) { 
                Log::error('PayTR callback hash doğrulama hatası.'); 
                return response('PAYTR notification failed: bad hash', 400);  
            }

            $cart = \Webkul\Checkout\Models\Cart::where('merchant_oid', $post['merchant_oid'])->first();
            
            if (!$cart) {
                Log::error('PayTR callback cart bulunamadı.');
                session()->flash('error', trans('shop::app.checkout.cart.empty'));
                return redirect()->route('shop.checkout.onepage.index'); 
            }

            // Order data'yı oluşturma ve cart_id'yi güncelleme

            $orderData = (new OrderResource($cart))->jsonSerialize();
            if ($post['status'] == 'success') {
                $existingOrder = Order::where('cart_id',$cart->id)->first();

                if ($existingOrder){
                    if ($existingOrder->status == 'pending'){
                        $existingOrder->status = 'processing';
                        $existingOrder->save(); 
                        echo 'OK';
                        exit();
                    }else {
                        echo 'OK';
                        exit();
                    } 
                }else{
                    $order = $this->orderRepository->create(data: $orderData);
                    $order->status = 'processing'; // HATA: $order tanımlı değil!
                    $order->save(); 
                }
                
                Log::info('Order :', $order); 
                echo "OK";
                exit;

            } else {
                //         'canceled'        => 'İptal Edildi',
                //         'closed'          => 'Kapatıldı',
                //         'completed'       => 'Tamamlandı',
                //         'fraud'           => 'Sahtekarlık',
                //         'pending'         => 'Beklemede',
                //         'pending-payment' => 'Ödeme Bekliyor',
                //         'processing'      => 'İşleniyor',

                // $order = $this->orderRepository->create(data: $orderData);
                $existingOrder = Order::where('cart_id',$cart->id)->first();
                $existingOrder->status = 'canceled';
                $existingOrder->failed_reason_code = $post['failed_reason_code'] ?? null;
                $existingOrder->failed_reason_msg = $post['failed_reason_msg'] ?? null;
                $existingOrder->save(); 
        
                session()->flash('error', trans('shop::app.checkout.payment-failed'));
                Log::info('Order :', $existingOrder);
                echo "OK";
                exit;
                // return redirect()->route('shop.checkout.onepage.index'); 
            }
        } catch (\Exception $e) { 
            Log::error('PAYTR Callback Hatası: ' . $e->getMessage()); 
            echo 'OK';
            exit();
            return response('PAYTR notification failed: ' . $e->getMessage(), 500);
        }
        echo 'OK';
        exit();
    }
 
    public function paytr_payment_success()
    {

        //Log::info('PAYTR POST Data:', ['cart' => 'islememler ile gelen']);
        Cart::deActivateCart();

        session()->flash('success', 'Siparişiniz Başarılı Bir Şekide Alındı !');

        return redirect()->route('shop.checkout.onepage.index');
        // return redirect()->route('shop.customers.account.orders.index');
    }

    // fail tarafı ayrı kodlanacak
    public function paytr_payment_fail()
    {
        $cart = Cart::getCart();

        if (!$cart) {
            session()->flash('error', trans('shop::app.checkout.cart.empty'));
            return redirect()->route('shop.checkout.onepage.index');
        }

        // $orderData = (new OrderResource($cart))->jsonSerialize();
        $existingOrder = Order::where('cart_id', $cart->id)->first();
        if ($existingOrder) {
            $existingOrder->status = 'canceled';
            $existingOrder->failed_reason_code = 'payment_failed';
            $existingOrder->failed_reason_msg = 'Ödeme başarısız oldu.';
            $existingOrder->save(); 
        }
        Log::info('PAYTR POST Data:', ['cart' => $cart, 'order' => $existingOrder,"status" => 'canceled',"failed_reason_code" => 'payment_failed', 'failed_reason_msg' => 'Ödeme başarısız oldu.']);
        // $order = $this->orderRepository->create($orderData);
        // $existingOrder = Order::where('cart_id',$cart->id)->first();
        // $order->status = 'canceled'; 
        // $order->failed_reason_code = $post['failed_reason_code'];
        // $order->failed_reason_msg = $post['failed_reason_msg'];
        // $order->save(); 

        session()->flash('error', trans('shop::app.checkout.payment-failed'));
        return redirect()->route('shop.checkout.onepage.index');
    }

}
