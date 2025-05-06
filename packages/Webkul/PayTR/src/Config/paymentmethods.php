<?php
// Config/paymentmethods.php

return [
    'paytr' => [
        'code' => 'paytr',
        'title' => 'PayTR',
        'description' => 'PayTR ile güvenli ödeme yapın',
        'class' => \Webkul\PayTR\Payment\PayTR::class,
        'active' => true,
        'sort' => 5,
    ],
];

// Config/system.php dosyası için eklenecek kısım
/*
return [
    [
        'key' => 'sales.paymentmethods.paytr',
        'name' => 'admin::app.admin.system.paytr',
        'sort' => 7,
        'fields' => [
            [
                'name' => 'title',
                'title' => 'admin::app.admin.system.title',
                'type' => 'text',
                'validation' => 'required',
                'channel_based' => true,
                'locale_based' => true,
            ], [
                'name' => 'description',
                'title' => 'admin::app.admin.system.description',
                'type' => 'textarea',
                'channel_based' => true,
                'locale_based' => true,
            ], [
                'name' => 'active',
                'title' => 'admin::app.admin.system.status',
                'type' => 'boolean',
                'validation' => 'required',
                'channel_based' => true,
                'locale_based' => false,
            ], [
                'name' => 'merchant_id',
                'title' => 'admin::app.admin.system.merchant-id',
                'type' => 'text',
                'validation' => 'required',
                'channel_based' => true,
                'locale_based' => false,
            ], [
                'name' => 'merchant_key',
                'title' => 'admin::app.admin.system.merchant-key',
                'type' => 'text',
                'validation' => 'required',
                'channel_based' => true,
                'locale_based' => false,
            ], [
                'name' => 'merchant_salt',
                'title' => 'admin::app.admin.system.merchant-salt',
                'type' => 'text',
                'validation' => 'required',
                'channel_based' => true,
                'locale_based' => false,
            ], [
                'name' => 'test_mode',
                'title' => 'admin::app.admin.system.test-mode',
                'type' => 'boolean',
                'validation' => 'required',
                'channel_based' => true,
                'locale_based' => false,
            ], [
                'name' => 'sort',
                'title' => 'admin::app.admin.system.sort-order',
                'type' => 'select',
                'options' => [
                    [
                        'title' => '1',
                        'value' => 1,
                    ], [
                        'title' => '2',
                        'value' => 2,
                    ], [
                        'title' => '3',
                        'value' => 3,
                    ], [
                        'title' => '4',
                        'value' => 4,
                    ], [
                        'title' => '5',
                        'value' => 5,
                    ],
                ],
            ],
        ],
    ],
];
*/