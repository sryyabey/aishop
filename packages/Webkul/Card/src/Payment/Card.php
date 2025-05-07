<?php

namespace Webkul\Card\Payment;

use Webkul\Payment\Payment\Payment;

class Card extends Payment
{
    /**
     * Payment method code
     */
    protected $code = 'card';

    /**
     * Return payment method title
     */
    public function getTitle()
    {
        // return __('card::app.admin.system.card-payment');
        return __('Kredi Kartı');
    }
    public function getImage()
    {
        return __('/themes/shop/default/build/assets/credit-card.svg');
    }
    /**
     * Return payment method description
     */
    public function getDescription()
    {
        // return __('card::app.admin.system.payment-description');
        return __('Kredi Kartı İle Ödeme');
    }

    /**
     * Return form view
     */
    public function getRedirectUrl()
    {
        return route('get_payment_token');
    }
}