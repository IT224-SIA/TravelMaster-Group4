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
        $this->baseUrl = env('WEATHERAPI_BASE_URL');
        $this->host = env('WEATHERAPI_HOST');
        $this->apiKey = env('WEATHERAPI_API_KEY');
    }

    public function getWeatherForecast($city, $days)
    {
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl . "/forecast.json", [
            'query' => [
                'q' => $city,
                'days' => $days,
            ],
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

    public function getTimeZone($city)
    {
        $client = new Client();

        $response = $client->request('GET', $this->baseUrl . "/timezone.json", [
            'query' => [
                'q' => $city,
            ],
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
