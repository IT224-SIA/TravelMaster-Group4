<?php

// We're defining the namespace for the controllers in the App\Http directory
namespace App\Http\Controllers;

// We're importing the Request class from Illuminate\Http for handling HTTP requests
use Illuminate\Http\Request;

// We're importing the GeoDBService class from App\Services for interacting with a Geo database service
use App\Services\GeoDBService;


/**
 * This controller handles all requests related to the GeoDB Cities API.
 * It provides methods for retrieving country details, country regions, city details, place details,
 * and more.
 * All methods require the user to be authenticated.
 */
class GeoDBController extends Controller
{
    // Declaring a property of type GeoDBService. The protected keyword means that it can be accessed only within this class
    protected $geoDBService;


    /**
     * Constructs a new instance of the GeoDBController class.
     *
     * @param GeoDBService $geoDBService The GeoDBService instance to be used by the controller.
     */
    public function __construct(GeoDBService $geoDBService)
    {
        $this->geoDBService = $geoDBService;
    }


    /**
     * This function retrieves the country details based on the provided country code.
     *
     * @param string $countryCode The code of the country.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the country details.
     */
    public function getCountryDetails($countryCode)
    {
        // This checks if the user is authenticated, otherwise it returns an 'Unauthenticated' JSON
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // retrieve currently authenticated user
        $user = auth()->user();

        // This returns the country details as a JSON response based on the countryCode 
        // given by calling the getCountryDetails method in the GeoDBService class
        return response()->json($this->geoDBService->getCountryDetails($countryCode));
    }


    /**
     * This function retrieves region details of a country based on the provided country code.
     *
     * @param string $countryCode The code of the country.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the region details.
     */
    public function getCountryRegions($countryCode)
    {
        // checks if the user is authenticated, otherwise it returns an 'Unauthenticated' JSON
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // retrieve currently authenticated user
        $user = auth()->user();

        // This returns the region details as a JSON response based on the countryCode 
        // given by calling the getCountryRegions method in the GeoDBService class
        return response()->json($this->geoDBService->getCountryRegions($countryCode));
    }


    /**
     * This function retrieves the details of a country region.
     *
     * @param string $countryCode The code of the country.
     * @param string $regionCode The code of the region.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the country region details.
     */
    public function getCountryRegionDetails($countryCode, $regionCode)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // retrieve currently authenticated user
        $user = auth()->user();

        // calls the getCountryRegionDetails method in the GeoDBService class and returns the region details in JSON
        return response()->json($this->geoDBService->getCountryRegionDetails($countryCode, $regionCode));
    }


    /**
     * This function retrieves the details of a city.
     *
     * @param int $cityId The ID of the city.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the city details.
     */
    public function getCityDetails($cityId)
    {
        // checks if the user is authenticated, otherwise it returns an 'Unauthenticated' JSON
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // retrieve currently authenticated user
        $user = auth()->user();

        // calls the getCityDetails method in the GeoDBService class and returns the city details in JSON
        return response()->json($this->geoDBService->getCityDetails($cityId));
    }


    /**
     * This retrieves the cities near a specified city.
     *
     * @param Request $request The HTTP request.
     * @param int $cityId The ID of the city.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the cities near the given city.
     */
    public function getCitiesNearCity(Request $request, $cityId)
    {
        // checks if the user is authenticated, otherwise it returns an 'Unauthenticated' JSON
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // retrieve currently authenticated user
        $user = auth()->user();

        $radius = $request->query('radius', 100); // The default radius is 100 if not specified in query params

        // calls the getCitiesNearCity method in the GeoDBService class and returns the cities near the given city in JSON
        return response()->json($this->geoDBService->getCitiesNearCity($cityId, $radius));
    }


    /**
     * Retrieves the details of a place.
     *
     * @param int $placeId The ID of the place.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPlaceDetails($placeId)
    {
        // checks if the user is authenticated, otherwise it returns an 'Unauthenticated' JSON
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // retrieve currently authenticated user
        $user = auth()->user();

        // calls the getPlaceDetails method in the GeoDBService class and returns the place details in JSON
        return response()->json($this->geoDBService->getPlaceDetails($placeId));
    }


    /**
     * Retrieves the places near a specified place.
     *
     * @param int $placeId The ID of the place.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPlacesNearPlace($placeId)
    {
        // checks if the user is authenticated, otherwise it returns an 'Unauthenticated' JSON
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // retrieve currently authenticated user
        $user = auth()->user();

        // calls the getPlacesNearPlace method in the GeoDBService class and returns the places near the given place in JSON
        return response()->json($this->geoDBService->getPlacesNearPlace($placeId));
    }


    /**
     * Retrieves the date and time of a specified place.
     *
     * @param int $placeId The ID of the place.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPlaceDateTime($placeId)
    {
        // checks if the user is authenticated, otherwise it returns an 'Unauthenticated' JSON
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // retrieve currently authenticated user
        $user = auth()->user();

        // calls the getPlaceDateTime method in the GeoDBService class and returns the date and time of the place in JSON
        return response()->json($this->geoDBService->getPlaceDateTime($placeId));
    }


    /**
     * Retrieves the time of a place.
     *
     * @param int $placeId The ID of the place.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPlaceTime($placeId)
    {
        // checks if the user is authenticated, otherwise it returns an 'Unauthenticated' JSON
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // retrieve currently authenticated user
        $user = auth()->user();

        // calls the getPlaceTime method in the GeoDBService class and returns the time of the place in JSON
        return response()->json($this->geoDBService->getPlaceTime($placeId));
    }
}