<?php

namespace App\Http\Controllers;

use App\User;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use URL;

class CompanyController extends Controller
{


    public function addCompany(Request $request){
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }
        $this->validate($request,[
            'company_name'=>'required',
            'company_address'=>'required',
            'company_email'=>'required|unique:companies',
            'company_phone'=>'required',
            'no_of_employees'=>'required',
            'city'=>'required',
            'state'=>'required',
            'zip_code'=>'required',
            'company_website'=>'required',
            'company_logo'=>'image|mimes:jpeg,png,svg,jpg|nullable',
            'services'=>'required'
        ]);

        $id = User::where('id',Auth::user()->id)->pluck('id')->first();
        $company = new Company;
        $company->company_name = $request->input('company_name');
        $company->user_id = $id;
        $company->company_address = $request->input('company_address');
        $company->company_email = $request->input('company_email');
        $company->company_phone = $request->input('company_phone');
        $company->no_of_employees = $request->input('no_of_employees');
        $company->city = $request->input('city');
        $company->state = $request->input('state');
        $company->zip_code = $request->input('zip_code');
        $company->company_website = $request->input('company_website');
        $company->services = $request->input('services');

        if($request->hasFile('company_logo')){
            $file = $request->file('company_logo');
            $file->move(public_path(). '/logos/', $file->getClientOriginalName());
            $url = URL::to("/") . '/logos/'. $file->getClientOriginalName();
            $company->company_logo = $url;
        }else{
            $company->company_logo = null;
        }


            $company->save();
            return response()->json([
                "status" => "success",
                "message" => "Company Details Added Successfully!",
                'company' => $company
              ], 200);
    }

    public function updateCompany(Request $request, $id){
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }
        $request->validate([
            'company_name'=>'required',
            'company_address'=>'required',
            'company_email'=>'required',
            'company_phone'=>'required',
            'no_of_employees'=>'required',
            'city'=>'required',
            'state'=>'required',
            'zip_code'=>'required',
            'company_website'=>'required',
            'company_logo'=>'nullable|image|mimes:jpeg,png,svg,jpg',
            'services'=>'required'
        ]);

        if (Company::where('id', $id)->exists()) {
            $company = Company::find($id);
            $company->company_name = $request->input('company_name');
            $company->company_address = $request->input('company_address');
            $company->company_email = $request->input('company_email');
            $company->company_phone = $request->input('company_phone');
            $company->no_of_employees = $request->input('no_of_employees');
            $company->city = $request->input('city');
            $company->state = $request->input('state');
            $company->zip_code = $request->input('zip_code');
            $company->company_website = $request->input('company_website');
            $company->services = $request->input('services');

        if($request->hasFile('company_logo')){
            $file = $request->file('company_logo');

            $file->move(public_path(). '/logos/', $file->getClientOriginalName());
            $url = URL::to("/") . '/logos/'. $file->getClientOriginalName();
            $company->company_logo = $url;
        }else{
            $company->company_logo = null;
        }

        }
        $company->update();

            return response()->json([
                "status" => "success",
                "message" => "Company Updated Successfully!",
                'company' => $company
              ], 200);

    }

}
