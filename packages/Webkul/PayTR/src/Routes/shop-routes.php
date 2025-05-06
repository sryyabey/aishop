<?php

use Illuminate\Support\Facades\Route;
use Webkul\PayTR\Http\Controllers\PayTRController;

Route::group(['middleware' => ['web']], function () {

    /**
     * PayTR payment routes
     */
    Route::get('/paytr-redirect', [PayTRController::class, 'redirect'])->name('paytr.redirect');

    Route::get('/paytr-success', [PayTRController::class, 'success'])->name('paytr.success');

    Route::get('/paytr-cancel', [PayTRController::class, 'failure'])->name('paytr.cancel');

    Route::post('/paytr-callback', [PayTRController::class, 'callback'])->name('paytr.callback');
});
