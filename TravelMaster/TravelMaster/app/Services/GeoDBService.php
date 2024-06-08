<?php

namespace App\Services;

use GuzzleHttp\Client;

class GeoDBService
{
    protected $client;
    protected $baseUrl;
    protected $host;
    protected $key;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = env('GEODB_BASE_URL');
        $this->host = env('GEODB_HOST');
        $this->key = env('GEODB_KEY');
    }

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

    public function getCountryDetails($countryCode)
    {
        return $this->request('GET', "/v1/geo/countries/{$countryCode}");
    }

    public function getCountryRegions($countryCode)
    {
        return $this->request('GET', "/v1/geo/countries/{$countryCode}/regions");
    }

    public function getCountryRegionDetails($countryCode, $regionCode)
    {
        return $this->request('GET', "/v1/geo/countries/{$countryCode}/regions/{$regionCode}");
    }

    public function getCityDetails($cityId)
    {
        return $this->request('GET', "/v1/geo/cities/{$cityId}");
    }

    public function getCitiesNearCity($cityId, $radius)
    {
        return $this->request('GET', "/v1/geo/cities/{$cityId}/nearbyCities", [
            'query' => [
                'radius' => $radius
            ]
        ]);
    }

    public function getCityDistance($fromCityId, $toCityId)
    {
        return $this->request('GET', "/v1/geo/cities/{$fromCityId}/distance", [
            'query' => [
                'toCityId' => $toCityId
            ]
        ]);
    }

    public function getCityTime($cityId)
    {
        return $this->request('GET', "/v1/geo/cities/{$cityId}/time");
    }

    public function getPlaceDetails($placeId)
    {
        return $this->request('GET', "/v1/geo/places/{$placeId}");
    }

    public function getPlacesNearPlace($placeId)
    {
        return $this->request('GET', "/v1/geo/places/{$placeId}/nearbyPlaces");
    }

    public function getPlaceDistance($placeId, $toPlaceId)
    {
        return $this->request('GET', "/v1/geo/places/{$placeId}/distance", [
            'query' => [
                'toPlaceId' => $toPlaceId
            ]
        ]);
    }

    public function getPlaceDateTime($placeId)
    {
        return $this->request('GET', "/v1/geo/places/{$placeId}/dateTime");
    }

    public function getPlaceTime($placeId)
    {
        return $this->request('GET', "/v1/geo/places/{$placeId}/time");
    }
}