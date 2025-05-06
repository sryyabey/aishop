<?php

namespace Webkul\Card\Payment;

use Webkul\Payment\Payment\Payment;

class Card extends Payment
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'card'; 

    public function getRedirectUrl()
    {
        return route('get_payment_token');
    }
}
