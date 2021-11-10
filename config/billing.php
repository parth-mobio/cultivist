<?php

return [
    'stripe' => [
        'us' => [
            'key' => env('STRIPE_KEY'),
            'secret' => env('STRIPE_SECRET'),
            'currency' => env('BG_CASHIER_CURRENCY'),
        ],
        'gb' => [
            'key' => env('EUR_GBP_STRIPE_KEY'),
            'secret' => env('EUR_GBP_STRIPE_SECRET'),
            'currency' => env('PL_CASHIER_CURRENCY'),
        ],
        'eur' => [
            'key' => env('EUR_GBP_STRIPE_KEY'),
            'secret' => env('EUR_GBP_STRIPE_SECRET'),
            'currency' => env('PL_CASHIER_CURRENCY'),
        ],

    ],
];
