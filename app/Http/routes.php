<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('app');
});


Route::group(['middleware' => ['api'],'prefix'=> 'api/v1'], function () {
    Route::post('authenticate','AuthenticateController@login');
    Route::post('register','AuthenticateController@register');
    Route::get('checkUserName','UserController@checkUserName');
    Route::get('checkEmail','UserController@checkEmail');
    Route::get('auth-user','UserController@getUser');
});
