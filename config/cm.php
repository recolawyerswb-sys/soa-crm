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

    'local' => [
        'wallet' => [
            'address' => env('CRM_LOCAL_WALLET_ADDRESS', ''),
            'coin' => env('CRM_LOCAL_WALLET_COIN', 'USDT'),
            'network' => env('CRM_LOCAL_WALLET_NETWORK', 'TRC20'),
        ],
    ],

];
