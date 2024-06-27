<?php

namespace App\Http\Controllers; // Defining the namespace

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
    protected $weatherAPIService; // Declaring the WeatherAPIService instance

    protected $validCities; // Declaring the variable for storing the valid city names

    /**
     * Constructor for the WeatherAPIController class.
     *
     * @param WeatherAPIService $weatherAPIService The WeatherAPIService instance.
     */
    public function __construct(WeatherAPIService $weatherAPIService)
    {
        $this->weatherAPIService = $weatherAPIService;

        define('CITIES_PATH', __DIR__ . '/../../Params/Cities.php'); // Defining the directory path of the file that contains the array of all valid city names

        $this->validCities = include CITIES_PATH; // Assigning the array to the variable
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
        $validCities = $this->validCities; // The variable that contains the array of valid cities

        // Checking for user authentication
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Checking if the city entered by the user is not in the array of valid cities
        if (!in_array($city, $validCities)) {
            return response()->json(['error' => 'City \'' . $city . '\' not found.'], 404);
        }

        $user = auth()->user();

        // Call the getWeatherForecast method from the WeatherAPIService and pass the arguments.
        // Save the response in a variable
        $response = $this->weatherAPIService->getWeatherForecast($city, $days);

        // Return the response in JSON format with the status code
        return response()->json($response['body'], $response['status']);
    }

    public function getTimeZone(Request $request, $city)
    {
        $validCities = $this->validCities; // The variable that contains the array of valid cities

        // Checking for user authentication
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();

        // Checking if the city entered by the user is not in the array of valid cities, return an error if so
        if (!in_array($city, $validCities)) {
            return response()->json(['error' => 'City \'' . $city . '\' not found.'], 404);
        }

        // Call the getTimeZone method from the WeatherAPIService and pass the arguments.
        $response = $this->weatherAPIService->getTimeZone($city);

        // Return the response in JSON format with the status code
        return response()->json($response['body'], $response['status']);
    }
}
