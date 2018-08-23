<?php

return [
    'clickatell' => [
        'api_key' => env('CLICKATELL_TOKEN'),
        'username' => env('CLICKATELL_USERNAME'),
        'password' => env('CLICKATELL_PASSWORD'),
        'log' => env('CLICKATELL_LOG', false),
        'log_table' => env('CLICKATELL_LOG_TABLE', 'clickatell_log'),
        'to' => env('CLICKATELL_FIELD', 'phone_number'),
        'callback_url' => env('CLICKATELL_CALLBACK_URL'),
    ],
];
