<?php

namespace App\Http\Controllers; // Defining the namespace

use App\Services\COVID19TrackingService; // Importing the CoVID19TrackingService class

/**
 * Controller for the COVID19 Tracking API
 * It has methods for getting COVID19 data of a country
 */
class COVID19TrackingController extends Controller
{
    protected $service; // Declaring a property of type COVID19TrackingService 

    protected $validCountries; // Declaring a variable where we will store the array of valid countries

    /**
     * Constructor for the class.
     *
     * @param COVID19TrackingService $service The COVID19TrackingService instance.
     * @return void
     */
    public function __construct(COVID19TrackingService $service)
    {
        $this->service = $service;

        define('COUNTRIES_PATH', __DIR__ . '/../../Params/Countries.php'); // Defining the directory path of the file that contains the array of all valid country names

        $this->validCountries = include COUNTRIES_PATH; // Assigning the array to the variable
    }

    /**
     * Retrieves the COVID-19 data for a specific country.
     *
     * @param string $country The name of the country.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the COVID-19 data.
     */
    public function getCountryData($country)
    {
        $validCountries = $this->validCountries; // The array of valid countries

        // Checking if the user is authenticated
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();

        // Checking if the country entered by user is in the array of valid countries, if so, return an error in JSON
        if (!in_array($country, $validCountries)) {
            return response()->json(['error' => 'Country \'' . $country . '\' not found.'], 404);
        }

        return response()->json($this->service->getCountryData($country)); // Calls the getCountryData method of the COVID19TrackingService and returns the data in JSON
    }
}
