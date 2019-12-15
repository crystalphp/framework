<?php

return [

    'middlewares' => [
        'required' => [

        ],
    ],

    'app_status' => [
    	'state' => env('STATUS_STATE'),
    	'type' => env('STATUS_TYPE'),
    ],

    'app_name' => env('APP_NAME'),
    'app_url' => env('APP_URL'),
    'public_path' => env('PUBLIC_PATH'),

    'database' => [
	   'use_db' => false,
        'name' => env('DB_NAME'),
        'host' => env('DB_HOST'),
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD'),
    ],

    'cookies_default_life_time' => 2592000,


];
