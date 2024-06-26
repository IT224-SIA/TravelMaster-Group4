<?php

// Defining namespace
namespace App\Services;

// Importing Client class from the GuzzleHttp package
use GuzzleHttp\Client;

/**
 * This class provides methods for interacting with the WeatherAPI.
 *
 * It uses the GuzzleHttp library to make HTTP requests to the WeatherAPI.
 * The base URL, host, and API key are set in the constructor using environment variables.
 */
class WeatherAPIService
{
    // Defining variables to store the base URL, host, and API key
    protected $baseUrl;
    protected $host;
    protected $apiKey;

    /**
     * Constructs a new instance of the WeatherAPIService class.
     *
     * This constructor initializes the base URL, host, and API key properties
     * by retrieving their values from the corresponding environment variables.
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseUrl = env('WEATHERAPI_BASE_URL');
        $this->host = env('WEATHERAPI_HOST');
        $this->apiKey = env('WEATHERAPI_API_KEY');
    }


    /**
     * Retrieves the weather forecast for a given city and number of days.
     *
     * @param string $city The name of the city to retrieve the weather forecast for.
     * @param int $days The number of days to retrieve the weather forecast for.
     * @return array An array containing the status code of the response and the decoded body of the response.
     */
    public function getWeatherForecast($city, $days)
    {
        // Creates an instance of the Client class
        $client = new Client();

        // Sends an HTTP GET request to the WeatherAPI and stores the response in a variable
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

        // Returns an array containing the status code of the response and the decoded body of the response
        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getBody(), true)
        ];
    }


    /**
     * Retrieves the timezone information for a given city.
     *
     * @param string $city The name of the city.
     * @return array An array containing the status code of the response and the decoded body of the response.
     */
    public function getTimeZone($city)
    {
        // Creates an instance of the Client class
        $client = new Client();

        // Sends an HTTP GET request to the WeatherAPI and stores the response in a variable
        $response = $client->request('GET', $this->baseUrl . "/timezone.json", [
            'query' => [
                'q' => $city,
            ],
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->apiKey,
            ],
        ]);

        // Returns an array containing the status code of the response and the decoded body of the response
        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getBody(), true)
        ];
    }
}
