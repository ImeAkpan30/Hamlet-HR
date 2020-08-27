<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyDepartmentController extends Controller
{

    public function getDepartments() {
        $departments = CompanyDepartment::all();
        return response()->json($departments, 200);
    }

    public function addDepartment(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }
        $this->validate($request,[
            'name'=>'required',
        ]);

        $company_id = Company::where('user_id',Auth::user()->id)->pluck('id')->first();
        $companyDept = new CompanyDepartment;
        $companyDept->name = $request->input('name');
        $companyDept->company_id = $company_id;


            $companyDept->save();
            return response()->json([
                "status" => "success",
                "message" => "Company Department Added Successfully!"
              ], 200);
    }


    public function updateDepartment(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }
        $this->validate($request,[
            'name'=>'required',
        ]);

        $company_id = Company::where('user_id',Auth::user()->id)->pluck('id')->first();
        $companyDept =  CompanyDepartment::find($id);
        $companyDept->name = $request->input('name');
        $companyDept->company_id = $company_id;
            $companyDept->save();
            return response()->json([
                "status" => "success",
                "message" => "Company Department Updated Successfully!"
              ], 200);
    }


}
