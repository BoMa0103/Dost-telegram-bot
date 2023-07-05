<?php

return [
    'bot' => [
        'api_token' => env('TELEGRAM_API_TOKEN'),

        'username' => env('TELEGRAM_BOT_USERNAME', ''),

        'api_url' => env('TELEGRAM_API_URL'),

        'webhook_url' => env('NGROK_URL') . env('TELEGRAM_WEBHOOK_URL'),
    ],

    'admins' => env('TELEGRAM_ADMINS', '')

];
