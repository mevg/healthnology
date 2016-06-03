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
    if(Auth::user()){
        return response()->json([
            'id'        =>  Auth::user()->id,
            'name'      =>  Auth::user()->name,
            'avatar'    =>  Auth::user()->avatar,
            'gender'    =>  Auth::user()->gender,
            'provider_id' => Auth::user()->provider_id
        ]);
    }
    else return view('welcome');
});

Route::group(['prefix' => 'api'], function(){
    Route::get('social/{provider?}', 'SocialController@getSocialAuth');
    Route::get('social/callback/{provider?}', 'SocialController@getSocialAuthCallback');
    //Route::get('social/logout', 'SocialController@getSocialLogOut');
});

Route::get("/logout",function(){
    Auth::logout();
    return redirect('/');
});
