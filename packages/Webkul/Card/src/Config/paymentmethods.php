<?php

return [
    'card'  => [
        'code'        => 'card',
        'title'       => 'Cart',
        'description' => 'Kredi Kartı İle Ödeme',
        'class'       => 'Webkul\Card\Payment\Card',
        'sandbox'     => true,
        'active'      => true,
        'sort'        => 6,
        'fields' => [
            'title' => [
                'type' => 'text',
                'name' => 'title',
                'title' => 'admin::app.admin.system.title',
                'validation' => 'required',
                'value' => 'Kredi/Banka Kartı',
            ],
            'description' => [ 
                'type' => 'textarea',
                'name' => 'description',
                'title' => 'admin::app.admin.system.description',
                'validation' => 'required',
                'value' => 'PayTR ile güvenli ödeme',
            ],
            'active' => [
                'type' => 'boolean',
                'name' => 'active',
                'title' => 'admin::app.admin.system.status',
                'validation' => 'required',
                'value' => true,
            ],
        ],
    ],
];

