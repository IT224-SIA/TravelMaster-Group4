<?php
namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Services\User1Service;

class User1Controller extends Controller
{
    use ApiResponser;

    /**
     * The service to consume the User1 Microservice
     * @var User1Service
     */
    public $user1Service;
    /**
     * Create a new controller instance
     * @return void
     */
    public function __construct(User1Service $user1Service)
    {
        $this->user1Service = $user1Service;
    }
    private $request;

    public function getUsers()
    {

    }
    /**
     * Return the list of users
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        // 
    return $this->successResponse($this->user1Service->obtainUsers1()); 

    }
    public function add(Request $request)
    {
        return $this->successResponse($this->user1Service->createUser1($request->all(), Response::HTTP_CREATED));
    }
    /**
     * Obtains and show one user
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->successResponse($this->user1Service->obtainUser1($id));
    }
    /**
     * Update an existing author
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->successResponse($this->user1Service->editUser1($request->all(), $id));
    }
    /**
     * Remove an existing user
     * @return Illuminate\Http\Response
     */
    public function delete($id)
    {
        return $this->successResponse($this->user1Service->deleteUser1($id));
    }

    public function convertIslamic(Request $request)
    {
        return $this->successResponse($this->user1Service->convertIslamic($request->all()));
    }

     # Email Authentication API I
    public function sendOTP(Request $request)
    {
        return $this->successResponse($this->user1Service->sendOTP());
    }

    # Telesign SMS Verify
    public function sendVerificationCode(Request $request)
    {
        $response = $this->telesignService->sendVerificationCode();
        return response()->json($response, $response['status']);
    }

    # Email Authentication API II
    public function sendOTPii(Request $request)
    {
        $recipient = $request->input('recipient');
        $app = $request->input('app');

        $response = $this->emailAuthService->sendOTP($recipient, $app);
        return response()->json($response, $response['status']);
    }

    # GeoDB Cities
    public function getCountryDetails(Request $request, $countryCode)
    {
        $response = $this->user1Service->getCountryDetails($countryCode);
        return response()->json($response, $response['status']);
    }

    public function getCountryRegions(Request $request, $countryCode)
    {
        $response = $this->user1Service->getCountryRegions($countryCode);
        return response()->json($response, $response['status']);
    }

    public function getCountryRegionDetails(Request $request, $countryCode, $regionCode)
    {
        $response = $this->user1Service->getCountryRegionDetails($countryCode, $regionCode);
        return response()->json($response, $response['status']);
    }

    public function getCityDetails(Request $request, $cityId)
    {
        $response = $this->user1Service->getCityDetails($cityId);
        return response()->json($response, $response['status']);
    }

    public function getCitiesNearCity(Request $request, $cityId)
    {
        $radius = $request->query('radius', 100); // Default radius is 100 if not specified in query params

        $response = $this->user1Service->getCitiesNearCity($cityId, $radius);
        return response()->json($response, $response['status']);
    }

    public function getCityDistance(Request $request, $fromCityId, $toCityId)
    {
        $response = $this->user1Service->getCityDistance($fromCityId, $toCityId);
        return response()->json($response, $response['status']);
    }

    public function getCityTime(Request $request, $cityId)
    {
        $response = $this->user1Service->getCityTime($cityId);
        return response()->json($response, $response['status']);
    }

    public function getPlaceDetails(Request $request, $placeId)
    {
        $response = $this->user1Service->getPlaceDetails($placeId);
        return response()->json($response, $response['status']);
    }

    public function getPlacesNearPlace(Request $request, $placeId)
    {
        $response = $this->user1Service->getPlacesNearPlace($placeId);
        return response()->json($response, $response['status']);
    }

    public function getPlaceDistance(Request $request, $placeId, $toPlaceId)
    {
        $response = $this->user1Service->getPlaceDistance($placeId, $toPlaceId);
        return response()->json($response, $response['status']);
    }

    public function getPlaceDateTime(Request $request, $placeId)
    {
        $response = $this->user1Service->getPlaceDateTime($placeId);
        return response()->json($response, $response['status']);
    }

    public function getPlaceTime(Request $request, $placeId)
    {
        $response = $this->user1Service->getPlaceTime($placeId);
        return response()->json($response, $response['status']);
    }
}

