<?php

namespace App\Http\Controllers; // We're defining the namespace for the controllers in the App\Http directory

use Illuminate\Http\Request; // We're importing the Request class from Illuminate\Http for handling HTTP requests

use App\Services\GeoDBService; // We're importing the GeoDBService class from App\Services for interacting with a Geo database service

/**
 * This controller handles all requests related to the GeoDB Cities API.
 * It provides methods for retrieving country details, country regions, city details, place details,
 * and more.
 * All methods require the user to be authenticated.
 */
class GeoDBController extends Controller
{
    protected $geoDBService; // Declaring a property of type GeoDBService. The protected keyword means that it can be accessed only within this class

    // Declaring variables to store arrays for valid country codes, region codes, city ids, and place ids
    protected $validCountryCodes;
    protected $validRegionCodes;
    protected $validCityIds;
    protected $validPlaceIds;

    /**
     * Constructs a new instance of the GeoDBController class.
     *
     * @param GeoDBService $geoDBService The GeoDBService instance to be used by the controller.
     */
    public function __construct(GeoDBService $geoDBService)
    {
        $this->geoDBService = $geoDBService;

        // Defining the directory paths of the files that contain the arrays for the valid country codes, region codes, city ids, and place ids
        define('COUNTRY_CODES_PATH', __DIR__ . '/../../Params/CountryCodes.php');
        define('REGION_CODES_PATH', __DIR__ . '/../../Params/RegionCodes.php');
        define('CITY_IDS_PATH', __DIR__ . '/../../Params/CityIDs.php');
        define('PLACE_IDS_PATH', __DIR__ . '/../../Params/PlaceIDs.php');

        // Assigning the arrays to the variables we declared earlier
        $this->validCountryCodes = include COUNTRY_CODES_PATH;
        $this->validRegionCodes = include REGION_CODES_PATH;
        $this->validCityIds = include CITY_IDS_PATH;
        $this->validPlaceIds = include PLACE_IDS_PATH;
    }

    /**
     * This function retrieves the country details based on the provided country code.
     *
     * @param string $countryCode The code of the country.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the country details.
     */
    public function getCountryDetails($countryCode)
    {
        $validCountryCodes = $this->validCountryCodes; // Declaring the variable with the array of valid country codes to make it accessible within this function block

        // Checking if the user is authenticated
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        $user = auth()->user();

        // Checking if the argument passed is not the array of valid country codes, if so, return a 404 error in JSON
        if (!in_array($countryCode, $validCountryCodes)) {
            return response()->json(['error' => 'Country not found for country id: ' . $countryCode], 404);
        }

        return response()->json($this->geoDBService->getCountryDetails($countryCode)); // If the user is authenticated and the country code is valid, return the country details in JSON

    }

    /**
     * This function retrieves region details of a country based on the provided country code.
     *
     * @param string $countryCode The code of the country.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the region details.
     */
    public function getCountryRegions($countryCode)
    {
        $validCountryCodes = $this->validCountryCodes; // Declaring the variable with the array of valid country codes to make it accessible within this function block

        // Checking for user authentication
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        $user = auth()->user();

        // Checking if the argument passed is not in the array of valid country codes, if so, return a 404 error in JSON
        if (!in_array($countryCode, $validCountryCodes)) {
            return response()->json(['error' => 'Country not found for country id: ' . $countryCode], 404);
        }

        return response()->json($this->geoDBService->getCountryRegions($countryCode)); // If the user is authenticated and the country code is valid, return the region details in JSON
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

        $validCountryCodes = $this->validCountryCodes; // Variable with the array of valid country codes
        $validRegionCodes = $this->validRegionCodes; // Variable with the array of valid region codes

        // Checking for user authentication
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        $user = auth()->user();

        // Checking if the arguments passed are in the arrays of valid country codes and region codes, if not, return a 404 error in JSON
        if (!in_array($countryCode, $validCountryCodes) || !in_array($regionCode, $validRegionCodes)) {
            if (!in_array($countryCode, $validCountryCodes) && !in_array($regionCode, $validRegionCodes)) {
                return response()->json(['error' => 'Country and Region invalid'], 404);
            } else if (!in_array($regionCode, $validRegionCodes)) {
                return response()->json(['error' => 'Region not found for region id: ' . $regionCode], 404);
            } else if (!in_array($countryCode, $validCountryCodes)) {
                return response()->json(['error' => 'Country not found for country id: ' . $countryCode], 404);
            } else {
                return response()->json(['error' => 'Country and Region invalid'], 404);

            }
        }

        return response()->json($this->geoDBService->getCountryRegionDetails($countryCode, $regionCode)); // Return the country region details in JSON if user is authenticated and arguments are valid
    }

    /**
     * This function retrieves the details of a city.
     *
     * @param int $cityId The ID of the city.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the city details.
     */
    public function getCityDetails($cityId)
    {
        $validCityIds = $this->validCityIds; // Variable with the array of valid city IDs

        // Checking for user authentication
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        $user = auth()->user();

        // If city ID entered by user is not in the array of valid city IDs, return a 404 error in JSON
        if (!in_array($cityId, $validCityIds)) {
            return response()->json(['error' => 'City not found for city id: ' . $cityId], 404);
        }

        // Return the city details in JSON if user is authenticated and city ID is valid
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
        $validCityIds = $this->validCityIds; // Variable with the array of valid city IDs

        // Checking for user authentication
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        $user = auth()->user();

        // Setting the default radius to 100 if none is provided
        $radius = $request->query('radius', 100);

        // If city ID entered by user is not in the array of valid city IDs, return a 404 error in JSON
        if (!in_array($cityId, $validCityIds)) {
            return response()->json(['error' => 'City not found for city id: ' . $cityId], 404);
        }

        // Return the cities near the given city in JSON if user is authenticated and city ID is valid
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
        $validPlaceIds = $this->validPlaceIds; // Variable with the array of valid place IDs

        // Checking for user authentication
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        $user = auth()->user();

        // If place ID entered by user is not in the array of valid place IDs, return a 404 error in JSON
        if (!in_array($placeId, $validPlaceIds)) {
            return response()->json(['error' => 'Place not found for place id: ' . $placeId], 404);
        }

        // Return the place details in JSON if user is authenticated and place ID is valid
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
        $validPlaceIds = $this->validPlaceIds; // Variable with the array of valid place IDs

        // Checking for user authentication
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();

        // If place ID entered by user is not in the array of valid place IDs, return a 404 error in JSON
        if (!in_array($placeId, $validPlaceIds)) {
            return response()->json(['error' => 'Place not found for place id: ' . $placeId], 404);
        }

        return response()->json($this->geoDBService->getPlacesNearPlace($placeId)); // Return the places near the given place in JSON
    }

    /**
     * Retrieves the date and time of a specified place.
     *
     * @param int $placeId The ID of the place.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPlaceDateTime($placeId)
    {
        $validPlaceIds = $this->validPlaceIds; // Variable with the array of valid place IDs

        // Checking for user authentication
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();

        // If place ID entered by user is not in the array of valid place IDs, return a 404 error in JSON
        if (!in_array($placeId, $validPlaceIds)) {
            return response()->json(['error' => 'Place not found for place id: ' . $placeId], 404);
        }

        // Return the date and time of the specified place in JSON
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
        $validPlaceIds = $this->validPlaceIds; // Variable with the array of valid place IDs

        // Checking for user authentication
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();

        // If place ID entered by user is not in the array of valid place IDs, return a 404 error in JSON
        if (!in_array($placeId, $validPlaceIds)) {
            return response()->json(['error' => 'Place not found for place id: ' . $placeId], 404);
        }

        // Return the time of the specified place in JSON
        return response()->json($this->geoDBService->getPlaceTime($placeId));
    }
}