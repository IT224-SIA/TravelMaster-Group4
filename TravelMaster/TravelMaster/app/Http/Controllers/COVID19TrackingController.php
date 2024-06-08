<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\COVID19TrackingService;

class COVID19TrackingController extends Controller
{
    protected $service;

    public function __construct(COVID19TrackingService $service)
    {
        $this->service = $service;
    }

    public function getCountryData($country)
    {
        return response()->json($this->service->getCountryData($country));
    }
}
