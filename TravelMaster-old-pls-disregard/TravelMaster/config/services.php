<?php

return [
    'geodb' => [
        'base_url' => env('GEODB_BASE_URL'),
        'host' => env('GEODB_HOST'),
        'key' => env('GEODB_KEY'),
    ],

    'weatherapi' => [
        'base_url' => env('WEATHERAPI_BASE_URL'),
        'host' => env('WEATHERAPI_HOST'),
        'key' => env('WEATHERAPI_API_KEY'),
    ],
    'covid19' => [
        'base_url' => env('COVID19_BASE_URL'),
        'host' => env('COVID19_SERVICE_HOST'),
        'key' => env('COVID19_SERVICE_KEY'),
    ],
    'taskmanager' => [
        'base_url' => env('TASKMANAGER_BASE_URL'),
        'host' => env('TASKMANAGER_HOST'),
        'key' => env('TASKMANAGER_KEY'),
    ]
];