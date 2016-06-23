<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class UserController extends Controller
{
    public function __construct()
	{
		 $this->middleware('jwt.auth')->only('getUser');
	}

    public function getUser()
    {
        $user = JWTAuth::parseToken()->authenticate();

        return $user;
    }

    public function checkUserName()
    {

        $username = Input::get('username');
        $user = User::where('username',$username)->first();
        if($user){
            return 'true';
        }

        return 'false';
    }

    public function checkEmail()
    {
        $email = Input::get('email');
        $user = User::where('email',$email)->first();
        if($user){
            return 'true';
        }

        return 'false';


    }
}
