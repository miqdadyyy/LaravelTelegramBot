<?php

return [
    /**
     *
     */

    'api_key' => env('TELEGRAM_BOT_KEY', 'your-telegram-key'),

    'base_url' => env('TELEGRAM_BOT_BASEURL', 'https://api.telegram.org/'),

    'webhook_url' => env('APP_URL', ''),
];