<?php

namespace App\Services;

use App\User;
use Validator;
use \Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ValidUserRegister;
use Illuminate\Foundation\Validation\ValidatesRequests;


class RegisterUser
{
    use ValidatesRequests;

    protected $properties = ['username','email','password'];
    protected $userModel;
    protected $mailClient;

    public function __construct(User $user,Mail $mail)
    {
        $this->userModel = $user;
        $this->mailClient = $mail;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'password_confirmed' => 'required|same:password'
        ]);
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $user = $this->userModel->create($request->only($this->properties));
        $token = JWTAuth::fromUser($user);
        //send email
//       $this->sendRegisterEmail($user);

        return $token;
    }

    public function sendRegisterEmail($user)
    {
        Mail::send('emails.register', ['user' => $user], function ($m) use ($user) {    
            $m->to($user->email, $user->username)->subject('Ďakujeme za registráciu!');
        });
    }
}