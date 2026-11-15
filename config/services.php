<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'qris' => [
        'sandbox_enabled' => env('QRIS_FAKE_ENABLED', env('APP_ENV', 'production') !== 'production'),
        'fake_unavailable' => env('QRIS_FAKE_UNAVAILABLE', false),
        'merchant_id' => env('QRIS_FAKE_MERCHANT_ID', 'ID.CO.AMAHAY.SANDBOX'),
        'merchant_name' => env('QRIS_FAKE_MERCHANT_NAME', 'AMAHAY SANDBOX'),
        'merchant_city' => env('QRIS_FAKE_MERCHANT_CITY', 'JAKARTA'),
    ],

    'bank_transfer' => [
        'banks' => [
            'bca' => 'BCA',
            'bni' => 'BNI',
            'bri' => 'BRI',
            'mandiri' => 'Mandiri',
            'bsi' => 'BSI',
        ],
    ],

];
