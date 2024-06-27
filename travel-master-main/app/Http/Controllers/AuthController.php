<?php

namespace App\Http\Controllers; // Define the namespace

// Import the necessary classes
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



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
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        // This validates the request data
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']); // This extracts the email and password from the request

        // This if statement attempts to authenticate the user
        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401); // If authentication fails, it returns an 'Unauthorized' error response
        }

        return $this->respondWithToken($token); // If authentication is successful, it returns the JWT token in the response

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user()); // This returns the authenticated user's information as a JSON response

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout(); // Logs the user out

        return response()->json(['message' => 'Successfully logged out']); // Returns a success message stating the user has been logged out
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh()); // Returns a JSON response containing the new access token

    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
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