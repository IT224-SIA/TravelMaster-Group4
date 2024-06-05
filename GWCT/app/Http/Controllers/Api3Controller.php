<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use App\Services\Api3Service;

class Api3Controller extends Controller
{
    use ApiResponser;
    /**
     * The service to consume the User1 Microservice
     * @var Api3Service
     */
    public $api3Service;
    /**
     * Create a new controller instance
     * @return void
     */

    public function __construct(Api3Service $api3Service)
    {
        $this->api3Service = $api3Service;
    }
    protected function successResponse($data)
    {
        return response()->json($data, 200);
    }

    public function signup(Request $request)
    {
        return $this->successResponse($this->api3Service->signUp($request->all()));
    }

    public function makeACollection(Request $request)
    {
        return $this->successResponse($this->api3Service->createCollection($request->all()));
    }
}
