<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeoDBService;
use App\Exceptions\BadRequestException;
use App\Exceptions\EntityNotFoundException;

class GeoDBController extends Controller
{
    protected $geoDBService;

    public function __construct(GeoDBService $geoDBService)
    {
        $this->geoDBService = $geoDBService;
    }

    public function getCountryDetails($countryCode)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();

        return response()->json($this->geoDBService->getCountryDetails($countryCode));
    }

    public function getCountryRegions($countryCode)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();
        
        return response()->json($this->geoDBService->getCountryRegions($countryCode));
    }

    public function getCountryRegionDetails($countryCode, $regionCode)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();
        
        return response()->json($this->geoDBService->getCountryRegionDetails($countryCode, $regionCode));
    }

    public function getCityDetails($cityId)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();
        return response()->json($this->geoDBService->getCityDetails($cityId));
    }

    public function getCitiesNearCity(Request $request, $cityId)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();
        $radius = $request->query('radius', 100); // Default radius is 100 if not specified in query params
        return response()->json($this->geoDBService->getCitiesNearCity($cityId, $radius));
    }

    public function getCityDistance(Request $request, $fromCityId)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();
        $toCityId = $request->query('toCityId');
        return response()->json($this->geoDBService->getCityDistance($fromCityId, $toCityId));
    }

    public function getCityTime($cityId)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();
        return response()->json($this->geoDBService->getCityTime($cityId));
    }

    public function getPlaceDetails($placeId)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();
        return response()->json($this->geoDBService->getPlaceDetails($placeId));
    }

    public function getPlacesNearPlace($placeId)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();
        return response()->json($this->geoDBService->getPlacesNearPlace($placeId));
    }

    public function getPlaceDistance(Request $request, $placeId)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();
        $toPlaceId = $request->query('toPlaceId');
        return response()->json($this->geoDBService->getPlaceDistance($placeId, $toPlaceId));
    }

    public function getPlaceDateTime($placeId)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();
        return response()->json($this->geoDBService->getPlaceDateTime($placeId));
    }

    public function getPlaceTime($placeId)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();
        return response()->json($this->geoDBService->getPlaceTime($placeId));
    }
}