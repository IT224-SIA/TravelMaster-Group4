<?php
namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Services\Api4Service;

class Api4Controller extends Controller
{
    use ApiResponser;

    /**
     * The service to consume the Api4 Microservice
     * @var Api4Service
     */
    public $api4Service;
    /**
     * Create a new controller instance
     * @return void
     */
    public function __construct(Api4Service $api4Service)
    {
        $this->api4Service = $api4Service;
    }
    private $request;

    public function translateThis(Request $request)
    {
        return $this->successResponse($this->api4Service->translate($request->all(), Response::HTTP_CREATED));
    }

}
