<?php

// Defining the namespace
namespace App\Http\Controllers;

// Importing the required classes
use Illuminate\Http\Request;
use App\Services\WeatherAPIService;

/**
 * This controller handles all requests related to the Weather API.
 * It provides methods for retrieving weather forecast and timezone information.
 * All methods require the user to be authenticated.
 */
class WeatherAPIController extends Controller
{
    // Declaring the WeatherAPIService instance
    protected $weatherAPIService;


    /**
     * Constructor for the WeatherAPIController class.
     *
     * @param WeatherAPIService $weatherAPIService The WeatherAPIService instance.
     */
    public function __construct(WeatherAPIService $weatherAPIService)
    {
        $this->weatherAPIService = $weatherAPIService;
    }


    /**
     * Retrieves the weather forecast for a given city and number of days.
     *
     * @param Request $request The HTTP request object.
     * @param string $city The name of the city.
     * @param int $days The number of days to retrieve the forecast for.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the weather forecast and status code.
     */
    public function getWeatherForecast(Request $request, $city, $days)
    {
        // Check for user authentication, throws an error if not authenticated
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Get the authenticated user
        $user = auth()->user();

        // Call the getWeatherForecast method from the WeatherAPIService and pass the arguments.
        // Save the response in a variable
        $response = $this->weatherAPIService->getWeatherForecast($city, $days);

        // Return the response in JSON format
        return response()->json($response['body'], $response['status']);
    }


    /**
     * Retrieves the timezone information for a given city.
     *
     * @param Request $request The HTTP request object.
     * @param string $city The name of the city.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the timezone information and status code.
     */
    public function getTimeZone(Request $request, $city)
    {
        // Check for user authentication, throws an error if not authenticated
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Get the authenticated user
        $user = auth()->user();

        // Call the getTimeZone method from the WeatherAPIService and pass the arguments. 
        // Save the response in a variable 
        $response = $this->weatherAPIService->getTimeZone($city);

        // Return the response in JSON format
        return response()->json($response['body'], $response['status']);
    }
}
