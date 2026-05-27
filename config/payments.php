<?php

return [
    'dp_percentage' => (int) env('PAYMENT_DP_PERCENTAGE', 50),

    'default_bank' => env('PAYMENT_DEFAULT_BANK', 'bca'),

    'banks' => [
        'bca' => [
            'name' => env('PAYMENT_BCA_BANK_NAME', 'Bank BCA'),
            'account_number' => env('PAYMENT_BCA_ACCOUNT_NUMBER', '1234567890'),
            'account_name' => env('PAYMENT_BCA_ACCOUNT_NAME', 'TailorTrack Indonesia'),
        ],
        'bri' => [
            'name' => env('PAYMENT_BRI_BANK_NAME', 'Bank BRI'),
            'account_number' => env('PAYMENT_BRI_ACCOUNT_NUMBER', '0987654321'),
            'account_name' => env('PAYMENT_BRI_ACCOUNT_NAME', 'TailorTrack Indonesia'),
        ],
        'mandiri' => [
            'name' => env('PAYMENT_MANDIRI_BANK_NAME', 'Bank Mandiri'),
            'account_number' => env('PAYMENT_MANDIRI_ACCOUNT_NUMBER', '1122334455'),
            'account_name' => env('PAYMENT_MANDIRI_ACCOUNT_NAME', 'TailorTrack Indonesia'),
        ],
    ],
];
