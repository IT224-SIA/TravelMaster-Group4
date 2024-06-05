<?php

namespace App\Services;

use GuzzleHttp\Client;

class COVID19TrackingService
{
    protected $baseUrl;
    protected $host;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.covid19.base_url');
        $this->host = config('services.covid19.host');
        $this->apiKey = config('services.covid19.api_key');
    }

    public function getCountryData($country)
    {
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl . "/v1/{$country}", [
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->apiKey,
            ],
        ]);

        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getBody(), true)
        ];
    }
}
