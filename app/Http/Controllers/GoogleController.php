<?php

namespace App\Http\Controllers;

use App\User;
use App\Company;
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
       $profile->phone = '000-000-000';
       $profile->address = 'Nigeria';
       $profile->profile_pic = ($google_user->avatar) ? $google_user->avatar : URL::to("/") . '/logos/avater.png';
       $profile->save();

           //create company account for user
        $company = new Company();
        $company->company_name =  $google_user->name.' Company';
        $company->user_id = User::where('id',auth()->user()->id)->pluck('id')->first();
        $company->company_address = 'Company Address';
        $company->company_email = 'example@company.com';
        $company->company_phone = '+000_000_000';
        $company->no_of_employees = 20;
        $company->city = '_';
        $company->state = '_';
        $company->zip_code = '10j901-1';
        $company->company_website = 'www.example.com';
        $company->services = 'Software Development';
        $company->company_logo =URL::to("/") . '/logos/avater.png';
        $company->save();          

       return $this->respondWithToken($token, $user);
    }
    public function google(){
        return Socialite::driver('google')->redirect();
    }
    protected function respondWithToken($token,$user)
    {
      return redirect("https://hamlethr.netlify.app/google/site#$token");  //live link
    }
}
