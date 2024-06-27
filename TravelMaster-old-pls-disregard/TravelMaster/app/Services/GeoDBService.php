<?php

// Defining the namespace
namespace App\Services;

// Importing Client class from the GuzzleHttp package
use GuzzleHttp\Client;

/**
 * This class provides methods to interact with the GeoDB Cities API.
 * The API base URL, host, and key are loaded from the environment variables.
 */
class GeoDBService
{
    // Declaring a protected property for the Guzzle client
    protected $client;

    // Declaring protected properties for the API base URL, host, and key
    protected $baseUrl;
    protected $host;
    protected $key;

    /**
     * Constructor for the GeoDBService class.
     */
    public function __construct()
    {
        // Initializing the Guzzle client
        $this->client = new Client();

        // Loading the API base URL, host, and key from the environment variables
        $this->baseUrl = env('GEODB_BASE_URL');
        $this->host = env('GEODB_HOST');
        $this->key = env('GEODB_KEY');
    }


    /**
     * Sends a request to the specified URI using the specified HTTP method and returns the response body as an associative array.
     *
     * @param string $method The HTTP method to use for the request.
     * @param string $uri The URI to send the request to.
     * @param array $params Additional parameters to include in the request.
     * @return array The response body as an associative array.
     */
    protected function request($method, $uri, $params = [])
    {
        $response = $this->client->request($method, $this->baseUrl . $uri, array_merge([
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key,
            ]
        ], $params));

        return json_decode($response->getBody()->getContents(), true);
    }


    /**
     * Retrieves the details of a specific country.
     *
     * @param string $countryCode The code of the country.
     * @return mixed The response from the API.
     */
    public function getCountryDetails($countryCode)
    {
        return $this->request('GET', "/v1/geo/countries/{$countryCode}");
    }


    /**
     * Retrieves the regions of a specific country.
     *
     * @param string $countryCode The code of the country.
     * @return mixed The response from the API containing the regions of the country.
     */
    public function getCountryRegions($countryCode)
    {
        return $this->request('GET', "/v1/geo/countries/{$countryCode}/regions");
    }


    /**
     * Retrieves the details of a specific region within a country.
     *
     * @param string $countryCode The code of the country.
     * @param string $regionCode The code of the region.
     * @return mixed The response from the API containing the details of the region.
     */
    public function getCountryRegionDetails($countryCode, $regionCode)
    {
        return $this->request('GET', "/v1/geo/countries/{$countryCode}/regions/{$regionCode}");
    }


    /**
     * Retrieves the details of a specific city using the given city ID.
     *
     * @param int $cityId The ID of the city.
     * @return mixed The response from the API containing the details of the city.
     */
    public function getCityDetails($cityId)
    {
        return $this->request('GET', "/v1/geo/cities/{$cityId}");
    }


    /**
     * Retrieves the cities near a specific city based on the city ID and radius.
     *
     * @param int $cityId The ID of the city.
     * @param int $radius The radius within which to search for nearby cities.
     * @return mixed The response from the API containing the nearby cities.
     */
    public function getCitiesNearCity($cityId, $radius)
    {
        return $this->request('GET', "/v1/geo/cities/{$cityId}/nearbyCities", [
            'query' => [
                'radius' => $radius
            ]
        ]);
    }


    /**
     * Retrieves the distance between two cities using their IDs.
     *
     * @param int $fromCityId The ID of the starting city.
     * @param int $toCityId The ID of the destination city.
     * @return mixed The response from the API containing the distance between the cities.
     */
    public function getCityDistance($fromCityId, $toCityId)
    {
        return $this->request('GET', "/v1/geo/cities/{$fromCityId}/distance", [
            'query' => [
                'toCityId' => $toCityId
            ]
        ]);
    }

    /**
     * Retrieves the time of a specific city based on the city ID.
     *
     * @param int $cityId The ID of the city.
     * @return mixed The response from the API containing the time of the city.
     */
    public function getCityTime($cityId)
    {
        return $this->request('GET', "/v1/geo/cities/{$cityId}/time");
    }


    /**
     * Retrieves the details of a specific place using the given place ID.
     *
     * @param int $placeId The ID of the place.
     * @return mixed The response from the API containing the details of the place.
     */
    public function getPlaceDetails($placeId)
    {
        return $this->request('GET', "/v1/geo/places/{$placeId}");
    }


    /**
     * Retrieves the nearby places for a specific place.
     *
     * @param int $placeId The ID of the place.
     * @return mixed The response from the API containing the nearby places.
     */
    public function getPlacesNearPlace($placeId)
    {
        return $this->request('GET', "/v1/geo/places/{$placeId}/nearbyPlaces");
    }


    /**
     * Retrieves the distance between two places using their IDs.
     *
     * @param int $placeId The ID of the starting place.
     * @param int $toPlaceId The ID of the destination place.
     * @return mixed The response from the API containing the distance between the places.
     */
    public function getPlaceDistance($placeId, $toPlaceId)
    {
        return $this->request('GET', "/v1/geo/places/{$placeId}/distance", [
            'query' => [
                'toPlaceId' => $toPlaceId
            ]
        ]);
    }


    /**
     * Retrieves the details of a specific place using the given place ID.
     *
     * @param int $placeId The ID of the place.
     * @return mixed The response from the API containing the details of the place.
     */
    public function getPlaceDateTime($placeId)
    {
        return $this->request('GET', "/v1/geo/places/{$placeId}/dateTime");
    }


    /**
     * Retrieves the time information for a specific place.
     *
     * @param int $placeId The ID of the place.
     * @return mixed The response from the API containing the time information for the place.
     */
    public function getPlaceTime($placeId)
    {
        return $this->request('GET', "/v1/geo/places/{$placeId}/time");
    }
}