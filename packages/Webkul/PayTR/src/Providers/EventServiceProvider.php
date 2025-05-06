<?php

namespace Webkul\PayTR\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen('checkout.payment.method.selected', function($paymentMethod) {
            if ($paymentMethod['method'] == 'paytr') {
                // Add custom scripts or styles if needed
            }
        });

        Event::listen('checkout.order.save.after', function($order) {
            // Handle anything after the order is saved
        });
    }
}