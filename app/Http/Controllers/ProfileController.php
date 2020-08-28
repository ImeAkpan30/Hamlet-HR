<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use URL;

class ProfileController extends Controller
{
    public function addProfile(Request $request){
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }

        $this->validate($request,[
            'first_name'=>'required',
            'last_name'=>'required',
            'address'=>'required',
            'profile_pic'=>'image|mimes:jpeg,png,svg,jpg|nullable',
        ]);

        $id = User::where('id',Auth::user()->id)->pluck('id')->first();

        $profile = new Profile;
        $profile->first_name = $request->input('first_name');
        $profile->user_id = $id;
        $profile->last_name = $request->input('last_name');
        $profile->address = $request->input('address');

        if($request->hasFile('profile_pic')){
            $file = $request->file('profile_pic');

            $file->move(public_path(). '/profiles/', $file->getClientOriginalName());
            $url = URL::to("/") . '/profiles/'. $file->getClientOriginalName();
            $profile->profile_pic = $url;
        }else{
            $profile->profile_pic = null;
        }

            $profile->save();
            return response()->json([
                "status" => "success",
                "message" => "Profile Added Successfully!"
              ], 200);
    }

    public function updateProfile(Request $request, $id){
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }
         $this->validate($request,[
            'first_name'=>'required',
            'last_name'=>'required',
            'address'=>'required',
            'profile_pic'=>'image|mimes:jpeg,png,svg,jpg|nullable',
        ]);
        if (Profile::where('id', $id)->exists()) {
            $profile = Profile::find($id);

            $profile->first_name = $request->input('first_name');
            $profile->last_name = $request->input('last_name');
            $profile->address = $request->input('address');


        if($request->hasFile('profile_pic')){
            $file = $request->file('profile_pic');

            $file->move(public_path(). '/profiles/', $file->getClientOriginalName());
            $url = URL::to("/") . '/profiles/'. $file->getClientOriginalName();
            $profile->profile_pic = $url;
        }else{
            $profile->profile_pic = null;
        }

        $data = array(
            'first_name' => $profile->first_name,
            'last_name' => $profile->last_name,
            'address' => $profile->address,
            'profile_pic' => $profile->profile_pic,
        );

        }

        Profile::where('id', $id)->update($data);
        $profile->update();

            return response()->json([
                "status" => "success",
                "message" => "Profile Updated Successfully!", $profile
              ], 200);

    }
}
