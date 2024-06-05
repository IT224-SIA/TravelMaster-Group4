<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\COVID19TrackingService;

class COVID19TrackingController extends Controller
{
    protected $covid19TrackingService;

    public function __construct(COVID19TrackingService $covid19TrackingService)
    {
        $this->covid19TrackingService = $covid19TrackingService;
    }

    public function getCountryData(Request $request, $country)
    {
        $response = $this->covid19TrackingService->getCountryData($country);
        return response()->json($response, $response['status']);
    }
}
