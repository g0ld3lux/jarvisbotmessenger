<?php


return [
    'router' => [
        'prefix'     => 'payment',
        'as'         => 'payment.',
    ],

    'storage' => [
        // options: eloquent, filesystem
        'token' => 'eloquent',

        // options: filesystem, database
        'gatewayConfig' => 'database',
    ],

    // 'customFactoryName' => [
    //     'factory'  => 'FactoryClass',
    //     'username' => 'username',
    //     'password' => 'password',
    //     'sandbox'  => false
    // ],
    'gatewayConfigs' => [
      'offline' => [
          'factory' =>'offline'
        ],
        'paypal_express_checkout' => [
           'factory' =>'paypal_express_checkout',
           'username'  => env('PAYPAL_EC_USERNAME'),
           'password'  => env('PAYPAL_EC_PASSWORD'),
           'signature' => env('PAYPAL_EC_SIGNATURE'),
           'sandbox'   => env('PAYPAL_EC_SANDBOX', true),
       ],
    ],
];
