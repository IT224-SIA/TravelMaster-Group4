<?php

// Defining the namespace
namespace App\Services;

// Importing Client class from the GuzzleHttp package
use GuzzleHttp\Client;

/**
 * This class provides methods to interact with the COVID-19 Tracking API.
 * The API base URL, host, and key are loaded from the environment variables.
 */
class COVID19TrackingService
{
    // Declaring a protected property for the Guzzle client
    protected $client;


    /**
     * Constructor for the class.
     *
     * @param Client $client - The client object.
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    /**
     * Retrieves data for a specific country from the COVID-19 Tracking API.
     *
     * @param string $country The name of the country.
     * @return array The JSON decoded response from the API.
     */
    public function getCountryData($country)
    {
        // Making a GET request to the API and passing the base URL, the country name, and the headers
        // and then storing the response in a variable first
        $response = $this->client->request('GET', 'https://covid-19-tracking.p.rapidapi.com/v1/' . $country, [
            'headers' => [
                'x-rapidapi-host' => env('COVID19_API_HOST'),
                'x-rapidapi-key' => env('COVID19_API_KEY'),
            ],
        ]);

        // returning the response in a decoded JSON format
        return json_decode($response->getBody()->getContents(), true);
    }
}
