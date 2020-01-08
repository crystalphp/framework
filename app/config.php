<?php

use Crystal\App\app;

return [

    'middlewares' => [
        'required' => [
            
        ],
    ],

    'app_status' => app::env('APP_STATUS'),
    'app_debug' => app::env('APP_DEBUG'),

    'app_name' => app::env('APP_NAME'),
    'app_url' => app::env('APP_URL'),
    'public_path' => app::env('PUBLIC_PATH'),

    'database' => [
        'use_db' => false,
        'db' => 'db1',
        'connections' => [
            'db1' => [
                'name' => app::env('DB_NAME'),
                'host' => app::env('DB_HOST'),
                'username' => app::env('DB_USERNAME'),
                'password' => app::env('DB_PASSWORD'),
            ],
        ],
    ],

    'cookies_default_life_time' => 2592000,


];
