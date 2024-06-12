<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherAPIService;

class WeatherAPIController extends Controller
{
    protected $weatherAPIService;

    public function __construct(WeatherAPIService $weatherAPIService)
    {
        $this->weatherAPIService = $weatherAPIService;
    }

    // public function getWeatherForecast(Request $request, $city, $days)
    // {
    //     $response = $this->weatherAPIService->getWeatherForecast($city, $days);
    //     return response()->json($response['body'], $response['status']);
    // }
    public function getWeatherForecast(Request $request, $city, $days)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();

        $response = $this->weatherAPIService->getWeatherForecast($city, $days);

        return response()->json($response['body'], $response['status']);
    }

    public function getTimeZone(Request $request, $city)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();
        $response = $this->weatherAPIService->getTimeZone($city);
        return response()->json($response['body'], $response['status']);
    }
}
