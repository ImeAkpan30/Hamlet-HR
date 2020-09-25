<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
class GoogleController extends Controller
{
    public function callback(){

        // get user from google
       $google_user= Socialite::driver('google')->user();
      // find user
        $checkUser=User::where('email', $google_user->email)->first();

    //    check if user exist in the database
    if ($checkUser) {
       //    login user
       $token = auth()->login($checkUser);
       $status="Login Succesfully";
       return $this->respondWithToken($token,$checkUser);
    }

    //    register User
       $user = new User();
       $user->username=  $google_user->name;
       $user->email=  $google_user->email;
       $user->role= "manager";
       $user->password=Hash::make($google_user->id);
       $user->save();

         //    login user
       $token = auth()->login($user);

       //create user profile
       $profile = new Profile();
       $profile->first_name =  $google_user->name;
       $profile->user_id =User::where('id',auth()->user()->id)->pluck('id')->first();
       $profile->last_name = '_';
       $profile->address = 'New york';
       $profile->profile_pic = ($google_user->avatar) ? $google_user->avatar : URL::to("/") . '/logos/avater.png';
       $profile->save();
       $status="Registered Succesfully";
       return $this->respondWithToken($token, $user);
    }
    public function google(){
        return Socialite::driver('google')->redirect();
    }
    protected function respondWithToken($token,$user)
    { 
      return redirect("https://hamlethr.netlify.app/profile/$token");  //test link
    }
}
