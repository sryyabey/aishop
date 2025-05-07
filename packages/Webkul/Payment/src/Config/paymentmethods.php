<?php

return [

    /// 'paytr'  => [
    ///     'code'        => 'paytr',
    ///     'title'       => 'PayTR',
    ///     'description' => 'PayTR',
    ///     'image'       => '/images/paytr.svg',
    ///     'class'       => 'Webkul\PayTR\Payment\PayTR',
    ///     'active'      => true,
    ///     'sort'        => 1, 
    /// ],
    'card'  => [
        'code'        => 'card',
        'title'       => 'Cart',
        'description' => 'Kredi Kartı İle Ödeme',
        'class'       => 'Webkul\Card\Payment\Card',
        'image'       => '/themes/shop/default/build/assets/credit-card.svg',
        'sandbox'     => true,
        'active'      => true,
        'sort'        => 1,
    ],
    'cashondelivery'  => [
        'code'        => 'cashondelivery',
        'title'       => 'Cash On Delivery',
        'description' => 'Cash On Delivery',
        'class'       => 'Webkul\Payment\Payment\CashOnDelivery',
        'active'      => true,
        'sort'        => 2,
    ],

    'moneytransfer'   => [
        'code'        => 'moneytransfer',
        'title'       => 'Money Transfer',
        'description' => 'Money Transfer',
        'class'       => 'Webkul\Payment\Payment\MoneyTransfer',
        'active'      => true,
        'sort'        => 3,
    ],
];
