<?php

namespace App\Http\Controllers;

use App\User;
use App\Company;
use App\Employee;
use App\CompanyDepartment;
use Illuminate\Http\Request;
use App\Events\Notifications;
use Illuminate\Support\Facades\Auth;

class CompanyDepartmentController extends Controller
{

    public function getDepartments($id) {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);
         }
         $company_id=Employee::where('id',$id)->pluck('company_id')->first();
        $departments = CompanyDepartment::where('company_id',$company_id)->get();
        return response()->json([
            'departments' => $departments
        ],);
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
        $companyDept = new CompanyDepartment();
        $companyDept->name = $request->input('name');
        $companyDept->company_id = $company_id;
            $companyDept->save();
                 // events
        event(new Notifications([$companyDept,Auth::user()],'companyDepartment_added'));
            return response()->json([
                "status" => "success",
                "message" => "Company Department Added Successfully!",
                'department' => $companyDept
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
            // events
   event(new Notifications([$companyDept,Auth::user()],'companyDepartment_updated'));
            return response()->json([
                "status" => "success",
                "message" => "Company Department Updated Successfully!",
                'department' => $companyDept
              ], 200);
    }


}
