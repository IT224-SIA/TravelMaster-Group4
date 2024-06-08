<?php

namespace App\Services;

use GuzzleHttp\Client;

class COVID19TrackingService
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getCountryData($country)
    {
        $response = $this->client->request('GET', 'https://covid-19-tracking.p.rapidapi.com/v1/' . $country, [
            'headers' => [
                'x-rapidapi-host' => env('COVID19_API_HOST'),
                'x-rapidapi-key' => env('COVID19_API_KEY'),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
