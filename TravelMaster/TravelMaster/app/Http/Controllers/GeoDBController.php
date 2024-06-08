<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeoDBService;

class GeoDBController extends Controller
{
    protected $geoDBService;

    public function __construct(GeoDBService $geoDBService)
    {
        $this->geoDBService = $geoDBService;
    }

    public function getCountryDetails($countryCode)
    {
        return response()->json($this->geoDBService->getCountryDetails($countryCode));
    }

    public function getCountryRegions($countryCode)
    {
        return response()->json($this->geoDBService->getCountryRegions($countryCode));
    }

    public function getCountryRegionDetails($countryCode, $regionCode)
    {
        return response()->json($this->geoDBService->getCountryRegionDetails($countryCode, $regionCode));
    }

    public function getCityDetails($cityId)
    {
        return response()->json($this->geoDBService->getCityDetails($cityId));
    }

    public function getCitiesNearCity(Request $request, $cityId)
    {
        $radius = $request->query('radius', 100); // Default radius is 100 if not specified in query params
        return response()->json($this->geoDBService->getCitiesNearCity($cityId, $radius));
    }

    public function getCityDistance(Request $request, $fromCityId)
    {
        $toCityId = $request->query('toCityId');
        return response()->json($this->geoDBService->getCityDistance($fromCityId, $toCityId));
    }

    public function getCityTime($cityId)
    {
        return response()->json($this->geoDBService->getCityTime($cityId));
    }

    public function getPlaceDetails($placeId)
    {
        return response()->json($this->geoDBService->getPlaceDetails($placeId));
    }

    public function getPlacesNearPlace($placeId)
    {
        return response()->json($this->geoDBService->getPlacesNearPlace($placeId));
    }

    public function getPlaceDistance(Request $request, $placeId)
    {
        $toPlaceId = $request->query('toPlaceId');
        return response()->json($this->geoDBService->getPlaceDistance($placeId, $toPlaceId));
    }

    public function getPlaceDateTime($placeId)
    {
        return response()->json($this->geoDBService->getPlaceDateTime($placeId));
    }

    public function getPlaceTime($placeId)
    {
        return response()->json($this->geoDBService->getPlaceTime($placeId));
    }
}