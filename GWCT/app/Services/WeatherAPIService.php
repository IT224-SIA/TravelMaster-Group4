<?php

namespace App\Services;

use GuzzleHttp\Client;

class WeatherAPIService
{
    protected $baseUrl;
    protected $host;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.weatherapi.base_url');
        $this->host = config('services.weatherapi.host');
        $this->apiKey = config('services.weatherapi.api_key');
    }

    public function getWeatherForecast($city, $days)
    {
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl . "/forecast.json?q={$city}&days={$days}", [
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

    public function getTimeZone()
    {
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl . "/timezone.json", [
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
