<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;
use Socialite;

class SocialController extends Controller
{
     public function __construct(){
        $this->middleware('guest');
    }

    public function getSocialAuth($provider=null)
    {
        if(!config("services.$provider")) abort('404');

        return Socialite::driver($provider)->redirect();
    }


    public function getSocialAuthCallback($provider=null)
    {
        if($user = Socialite::driver($provider)->user()){
            if($the_user = User::select()->where('email','=',$user->email)->first()){
                Auth::login($the_user);
               return response()->json($the_user);
            }else{
                $new_user = new User();
                $new_user->name = $user->name;
                $new_user->email = $user->email;
                $new_user->avatar = $user->avatar;
                $new_user->gender = $user->user['gender'];
                $new_user->provider_id = $user->id;
                $new_user->save();
                Auth::login($new_user);
                return response()->json($new_user);
            }
        }else{
            return '¡¡¡Algo fue mal!!!';
        }
    }

    public function getSocialLogOut(){
            Auth::logout();
            return redirect('/');
    }
}

