<?php

return [
    'clickatell' => [
        'api_key' => env('CLICKATELL_TOKEN'),
        'username' => env('CLICKATELL_USERNAME'),
        'password' => env('CLICKATELL_PASSWORD'),
        'track' => env('CLICKATELL_TRACK', false),
        'tracking_table' => env('CLICKATELL_TRACKING_TABLE', 'clickatell_tracking'),
        'to' => env('CLICKATELL_FIELD', 'phone_number'),
        'callback_url' => env('CLICKATELL_CALLBACK_URL'),
    ],
];
