<?php
// Http/routes.php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']], function () {  
    Route::prefix('paytr')->group(function () {
        // Payment redirect route
        Route::get('/redirect', [\Webkul\PayTR\Http\Controllers\PayTRController::class, 'redirect'])->name('paytr.redirect');
        
        // Callback routes
        Route::get('/success', [\Webkul\PayTR\Http\Controllers\PayTRController::class, 'success'])->name('paytr.success');
        Route::get('/cancel', [\Webkul\PayTR\Http\Controllers\PayTRController::class, 'cancel'])->name('paytr.cancel');
        
        // Notification callback (webhook)
        Route::post('/callback', [\Webkul\PayTR\Http\Controllers\PayTRController::class, 'callback'])->name('paytr.callback');
    });
});