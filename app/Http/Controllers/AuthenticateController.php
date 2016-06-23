<?php

namespace App\Http\Controllers;

use App\Services\RegisterUser;
use Illuminate\Http\Request;
use App\Http\Requests;
use JWTAuth;


class AuthenticateController extends Controller
{
    public function __construct(RegisterUser $registerUser)
    {
        $this->registerUser = $registerUser;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // if no errors are encountered we can return a JWT
        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $token = $this->registerUser->register($request);

        return response()->json(['token' => $token],200);

    }
}
