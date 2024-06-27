<?php

// Define the namespace
namespace App\Http\Controllers;

// Import the necessary classes
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{

    /**
     * Constructor for the class.
     *
     * Applies the 'auth:api' middleware to all routes except 'login', 'refresh', and 'logout'.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'logout']]);
    }


    /**
     * Authenticate user login request and return a JWT token if successful.
     *
     * @param  Request  $request The incoming request.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the JWT token.
     */
    public function login(Request $request)
    {
        // This validates the request data
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // This extracts the email and password from the request
        $credentials = $request->only(['email', 'password']);

        // This if statement attempts to authenticate the user
        if (!$token = Auth::attempt($credentials)) {
            // If authentication fails, it returns an 'Unauthorized' error response
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // If authentication is successful, it returns the JWT token in the response
        return $this->respondWithToken($token);
    }


    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        // This returns the authenticated user's information as a JSON response
        return response()->json(auth()->user());
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        // This logs the user out by invalidating the token
        auth()->logout();

        // This returns a JSON response indicating that the user has been successfully logged out
        return response()->json(['message' => 'Successfully logged out']);
    }


    /**
     * Refresh the user's access token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        // This returns a JSON response containing the new access token
        return $this->respondWithToken(auth()->refresh());
    }


    /**
     * Generate a JSON response containing the user's access token, token type, user information, and expiration time
     *
     * @param  string $token This is the user's access token.
     *
     * @return \Illuminate\Http\JsonResponse This is the JSON response that contains the user's access token, token type, user information, and expiration time
     */
    protected function respondWithToken($token)
    {
        // This generates the JSON response containing the user's access token, token type, user information, and expiration time
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user(),
            'expires_in' => auth()->factory()->getTTL() * 60 * 24
        ]);
    }
}