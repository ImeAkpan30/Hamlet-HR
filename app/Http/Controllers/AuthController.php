<?php

namespace App\Http\Controllers;


// use App\Mail\signupMail;
use App\Company;
use App\Profile;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;

class AuthController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register','getAuthUser', 'logout']]);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:100|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|max:20|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',

        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->messages()
            ], 422);
        }

        //create user account
        $user = new User();
        $user->fill($request->all());
        $user->password = bcrypt($request->password);
        $user->role = "manager";
        $user->save();

        // login user
        $token = auth()->login($user);

        //create user profile
        $profile = new Profile();
        $profile->first_name = $request->username;
        $profile->user_id =User::where('id',auth()->user()->id)->pluck('id')->first();
        $profile->last_name = '_';
        $profile->address = 'New york';
        $profile->phone = '_';
        $profile->profile_pic = URL::to("/") . '/logos/avater.png';
        $profile->save();

        //create company account for user
        $company = new Company();
        $company->company_name =  $request->username.'Company';
        $company->user_id = User::where('id',auth()->user()->id)->pluck('id')->first();
        $company->company_address = 'Company Address';
        $company->company_email = 'example@company.com';
        $company->company_phone = '+000_000_000';
        $company->no_of_employees = 20;
        $company->city = 'new york';
        $company->state = 'U.S.A';
        $company->zip_code = '10j901-1';
        $company->company_website = 'www.example.com';
        $company->services = 'Software Development';
        $company->company_logo =URL::to("/") . '/logos/avater.png';
        $company->save();
        return $this->respondWithToken($token);
    }

    public function login(Request $request)
    {
        $user = User::where('email',$request->email)
        ->where('banned_at', "<>",'')->first();
        if($user) {
            return response()->json(['message' => 'Banned User'], 451);
        }

        $credentials = $request->only(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
          return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
        }


    public function getAuthUser()
    {

        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }
        $user = User::where('id',Auth::user()->id)
        ->with('company')
        ->with('profile')
        ->with('employees')
        ->with('employees.jobDetails')
        ->with('employees.contactInfo')
        ->with('company.companyDepartments')
        ->first();
        return response()->json([
            'user' => $user
        ], 200);
    }

    public function logout() {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }
        auth()->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'User successfully signed out'
        ], 200);
    }

    protected function respondWithToken($token)
    {
      return response()->json([
        'token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 20160,
        'user' =>User::where('id',Auth::user()->id)
        ->with('company')
        ->with('profile')
        ->with('employees')
        ->with('employees.jobDetails')
        ->with('employees.contactInfo')
        ->with('company.companyDepartments')
        ->first()
      ]);
    }
}
