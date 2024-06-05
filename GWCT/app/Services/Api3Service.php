<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class Api3Service
{
    use ConsumesExternalService;

    /**
     * The base URL to be used for the requests
     * @var string
     */
    public $baseUrl;

    /**
     * The host to be used for the requests
     * @var string
     */
    public $host;

    /**
     * The API key to be used for the requests
     * @var string
     */
    public $key;

    public function __construct()
    {
        $this->baseUrl = config('services.api3.base_url');
        $this->host = config('services.api3.host');
        $this->key = config('services.api3.key');
    }

    public function signUp($data)
    {
        $headers = [
            'X-RapidAPI-Host' => $this->host,
            'X-RapidAPI-Key' => $this->key,
            'Content-Type' => 'application/json',
        ];

        return $this->performRequest('POST', 'https://kvstore.p.rapidapi.com/users', json_encode($data), $headers);
    }

    public function createCollection($data)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'X-RapidAPI-Host' => $this->host,
            'X-RapidAPI-Key' => $this->key,
            'content-type' => 'application/json',
        ];

        return $this->performRequest('POST', 'https://kvstore.p.rapidapi.com/collections', json_encode($data), $headers);
    }
}
