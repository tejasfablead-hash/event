<?php
/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */
return [
    'mode'    => env('PAYPAL_MODE', 'sandbox'), // sandbox or live
    'sandbox' => [
        'client_id'         => env('PAYPAL_SANDBOX_CLIENT_ID'),
        'client_secret'     => env('PAYPAL_SANDBOX_CLIENT_SECRET'),
        'app_id'            => env('PAYPAL_SANDBOX_APP_ID', ''),
    ],
    'currency' => env('PAYPAL_CURRENCY', 'USD'),
];


