<?php

namespace App\Http\Controllers;

use App\User;
use App\Admin;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function login(Request $request)
    {
        $email = User::where('role','admin')->pluck('email')->first();
        if ($request->email != $email ) {
            return response()->json(['message' => 'Unauthorized!'], 401);
         }else {
            $credentials = $request->only(['email', 'password']);
            if (!$token = auth()->attempt($credentials)) {
              return response()->json(['error' => 'Unauthorized'], 401);
            }
              return $this->respondWithToken($token);
         }
    }

    public function getAdmin()
    {

        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }
        $user = User::where('id',auth()->user()->id)
        ->where('role','admin')
        ->first();
        return response()->json([
            'admin' => $user
        ], 200);
    }

    public function getUsers()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);
         }
         $user = User::where('role','!=','admin')
        ->with('company')
        ->with('profile')
        ->with('employees')
        ->with('employees.jobDetails')
        ->with('employees.contactInfo')
        ->with('company.companyDepartments')
        ->paginate(5);
        return response()->json([
            'user' => $user
        ], 200);
    }

    public function getUserByEmail($email)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);
         }
       $user = User::where('email',$email)
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

    public function ban(Request $request)
    {
        $input = $request->all();
        if(!empty($input['id'])){
            $user = User::find($input['id']);
            $user->bans()->create([
			    'expired_at' => '+14 days',
			    'comment'=>$request->comment
			]);
        }

        return response()->json(['message' => 'User Banned Successfully..'], 200);
    }

    public function revoke($id)
    {
        if(!empty($id)){
            $user = User::find($id);
            $user->unban();
        }

        return response()->json(['message' => 'User Unbanned Successfully..'], 200);

    }

    public function getCompanies()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }
         $company = Company::with('user')
        ->with('employees')
        ->with('employees.jobDetails')
        ->with('employees.contactInfo')
        ->with('companyDepartments')
        ->paginate(5);
        return response()->json([
            'company' => $company
        ], 200);
    }


    public function logout() {
        auth()->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Admin successfully signed out'
        ], 200);
    }

    protected function respondWithToken($token)
    {
      return response()->json([
        'token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 20160,
      ]);
    }
}
