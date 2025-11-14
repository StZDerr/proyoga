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
    'lightgallery' => [
        'key' => env('LIGHTGALLERY_KEY'),
    ],
    
    'yandex_captcha' => [
        'client_key' => env('YANDEX_CAPTCHA_CLIENT_KEY'),
        'server_key' => env('YANDEX_CAPTCHA_SERVER_KEY'),
        'verify_url' => 'https://smartcaptcha.yandexcloud.net/validate',
    ],
    'vk' => [
        'token' => env('VK_TOKEN'),
        'api_version' => env('VK_API_VERSION', '5.131'),
        'user_id' => env('VK_USER_ID', '135353409'), // Ваш ID для получения уведомлений
        'chat_id' => env('VK_CHAT_ID', '2000000002'), // ID группового чата
    ],
    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
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

];
