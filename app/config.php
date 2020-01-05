<?php

use Crystal\App\app;

return [

    'middlewares' => [
        'required' => [
            
        ],
    ],

    'app_status' => [
    	'state' => app::env('STATUS_STATE'),
    	'type' => app::env('STATUS_TYPE'),
    ],

    'app_name' => app::env('APP_NAME'),
    'app_url' => app::env('APP_URL'),
    'public_path' => app::env('PUBLIC_PATH'),

    'database' => [
	   'use_db' => true,
        'name' => app::env('DB_NAME'),
        'host' => app::env('DB_HOST'),
        'username' => app::env('DB_USERNAME'),
        'password' => app::env('DB_PASSWORD'),
    ],

    'cookies_default_life_time' => 2592000,


];
