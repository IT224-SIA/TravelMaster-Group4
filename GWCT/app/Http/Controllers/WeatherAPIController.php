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

    public function getWeatherForecast(Request $request, $city, $days)
    {
        $response = $this->weatherAPIService->getWeatherForecast($city, $days);
        return response()->json($response, $response['status']);
    }

    public function getTimeZone(Request $request)
    {
        $response = $this->weatherAPIService->getTimeZone();
        return response()->json($response, $response['status']);
    }
}
