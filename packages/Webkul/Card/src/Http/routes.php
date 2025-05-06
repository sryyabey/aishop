<?php

Use Webkul\Card\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
Route::group(['middleware' => ['web']], function () {

    Route::get('get_payment_token',[PaymentController::class,'getPaymentToken'])->name('get_payment_token');

    Route::get('paytr_redirect',[PaymentController::class,'paytr_redirect'])->name('paytr_redirect');
    Route::post('paytr_payment_call',[PaymentController::class,'paytr_payment_call'])->name('paytr_payment_call');
    Route::get('paytr_payment_fail',[PaymentController::class,'paytr_payment_fail'])->name('paytr_payment_fail');
    Route::get('paytr_payment_success',[PaymentController::class,'paytr_payment_success'])->name('paytr_payment_success');

    // wallet
    Route::get('wallet_payment_success',[PaymentController::class,'wallet_payment_success'])->name('wallet_payment_success');
    Route::get('wallet_pos_call_back',[PaymentController::class,'wallet_pos_call_back'])->name('wallet_pos_call_back');
    //Route::get('/iyzico-redirect', 'Webkul\IyzicoPayment\Http\Controllers\PaymentController@redirect')->name('iyzico.redirect');
    //Route::get('/iyzico-success', 'Webkul\IyzicoPayment\Http\Controllers\PaymentController@success')->name('iyzico.success');
    //Route::post('/iyzico-callback', 'Webkul\IyzicoPayment\Http\Controllers\PaymentController@callback')->name('iyzico.callback');
});
