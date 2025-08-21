<?php

return [

    'default' => env('BROADCAST_DRIVER', 'log'),

    'connections' => [

        'reverb' => [
            'driver' => 'reverb',
            'app_id' => env('REVERB_APP_ID'), // tambahkan ini kalau perlu
            'host' => env('REVERB_HOST', 'localhost'),
            'port' => env('REVERB_PORT', 8080),
            'scheme' => env('REVERB_SCHEME', 'http'),
            'app_key' => env('REVERB_APP_KEY'),
            'app_secret' => env('REVERB_APP_SECRET'),
        ],

        'log' => [
            'driver' => 'log',
        ],

    ],

];
