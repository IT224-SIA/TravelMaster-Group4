<?php

// Defining the namespace
namespace App\Http\Controllers;

// Importing the required classes
use Illuminate\Http\Request;
use App\Services\COVID19TrackingService;

/**
 * Controller for the COVID19 Tracking API
 * It has methods for getting COVID19 data of a country
 */
class COVID19TrackingController extends Controller
{
    // Declaring a property of type COVID19TrackingService 
    protected $service;


    /**
     * Constructor for the class.
     *
     * @param COVID19TrackingService $service The COVID19TrackingService instance.
     * @return void
     */
    public function __construct(COVID19TrackingService $service)
    {
        $this->service = $service;
    }


    /**
     * Retrieves the COVID-19 data for a specific country.
     *
     * @param string $country The name of the country.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the COVID-19 data.
     */
    public function getCountryData($country)
    {
        // Checking if the user is authenticated
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Getting the user
        $user = auth()->user();

        // Calls the getCountryData method of the COVID19TrackingService class and returns the COVID-19 data in JSON
        return response()->json($this->service->getCountryData($country));
    }
}
