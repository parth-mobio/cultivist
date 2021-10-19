<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'stripe' => [
        'model' => App\customer::class,
        'key' => 'pk_test_51JXQbKSEyndK7NRv6haEkOPtVkdmlLhJwQBG7KXFOElbNxdeNKg798q0svD5ltnkEB1XJWCpY3ydjoRhoJBUTpsO00BGc3EOUF', //env('STRIPE_KEY'),
        'secret' => 'sk_test_51JXQbKSEyndK7NRv7Lfdcym8Z4xD0KzISYjOUuDAVQMRFrIENeAYuv5d4GlPr6j5m6YORvNQDMViW6UfAizBoTOJ005XjYgOT7' //env('STRIPE_SECRET'),
      ],
];
