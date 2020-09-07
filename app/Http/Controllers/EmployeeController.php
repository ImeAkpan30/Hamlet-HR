<?php

namespace App\Http\Controllers;

use App\Company;
use App\User;
use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use URL;
use File;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function getEmployees() {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }
         $employees = User::where('id',Auth::user()->id)
         ->with('employees.jobDetails')
        ->with('employees.contactInfo')
         ->first();
        return response()->json($employees, 200);
    }

    public function getEmployee($id) {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }
        $employees = Employee::where('user_id',$id)
        ->with('jobDetails')
        ->with('contactInfo')
        ->get();
        return response()->json($employees, 200);
    }

    public function getSingleEmployee($id){
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }
        if (Employee::where('id', $id)->exists()) {
            $employee = Employee::where('id', $id)
            ->with('jobDetails')
            ->with('contactInfo')
            ->get();
            return response()->json([
                'employee' => $employee
            ], 200);
          } else {
            return response()->json([
              "message" => "Employee not found"
            ], 404);
          }
        }

    public function addEmployee(Request $request){
        if (!Auth::check()) {
           return response()->json(['message' => 'Unauthorized!'], 401);

        }

        $this->validate($request,[
            'first_name'=>'required',
            'other_names'=>'required',
            'gender'=>'required',
            'dob'=>'required|date',
            'address'=>'required',
            'city'=>'required',
            'qualification'=>'required',
            'profile_pic'=>'image|mimes:jpeg,png|nullable',
        ]);

        $id = User::where('id',Auth::user()->id)->pluck('id')->first();
        $company_id = Company::where('user_id',Auth::user()->id)->pluck('id')->first();
        $employee = new Employee();
        $employee->first_name = $request->input('first_name');
        $employee->other_names = $request->input('other_names');
        $employee->user_id = $id;
        $employee->company_id = $company_id;
        $employee->gender = $request->input('gender');
        $employee->dob = $request->input('dob');
        $employee->address = $request->input('address');
        $employee->city = $request->input('city');
        $employee->qualification = $request->input('qualification');

        if($request->hasFile('profile_pic')){
            $file = $request->file('profile_pic');

            $file->move(public_path(). '/images/', $file->getClientOriginalName());
            $url = URL::to("/") . '/images/'. $file->getClientOriginalName();
            $employee->profile_pic = $url;
        }else{
            $employee->profile_pic = null;
        }


            $employee->save();
            // try{
            //     Mail::to($request->email)->send(new addEmployeeMail($request->all()));
            //    }catch(\Exception $error)
            //    {
            //     //  code here..
            //    }
            return response()->json([
                "status" => "success",
                "message" => "Employee Added Successfully!",
                'employee' => $employee
              ], 200);
    }


    public function updateEmployee(Request $request, $id){
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }
        $this->validate($request,[
            'first_name'=>'required',
            'other_names'=>'required',
            'gender'=>'required',
            'dob'=>'required',
            'address'=>'required',
            'city'=>'required',
            'qualification'=>'required',
            'profile_pic'=>'image|mimes:jpeg,png,jpg,svg|nullable',
        ]);

        if (Employee::where('id', $id)->exists()) {
            $company_id = Company::where('user_id',Auth::user()->id)->pluck('id')->first();
            $employee = Employee::find($id);
            $employee->first_name = $request->input('first_name');
            $employee->other_names = $request->input('other_names');
            $employee->gender = $request->input('gender');
            $employee->dob = $request->input('dob');
             $employee->company_id = $company_id;
            $employee->address = $request->input('address');
            $employee->city = $request->input('city');
            $employee->qualification = $request->input('qualification');

        if($request->hasFile('profile_pic')){

            // $image_path = public_path("images/{$employee->profile_pic}");
            // if (file_exists($image_path)){
            //     Storage::delete($image_path);
            // }
            $file = $request->file('profile_pic');

            $file->move(public_path(). '/images/', $file->getClientOriginalName());
            $url = URL::to("/") . '/images/'. $file->getClientOriginalName();
            $employee->profile_pic = $url;
        }else{
            $employee->profile_pic = null;
        }

        $data = array(
            'first_name' => $employee->first_name,
            'other_names' => $employee->other_names,
            'gender' => $employee->gender,
            'dob' => $employee->dob,
            'address' => $employee->address,
            'city' => $employee->city,
            'qualification' => $employee->qualification,
            'profile_pic' => $employee->profile_pic,
        );

        }

        Employee::where('id', $id)->update($data);
        $employee->update();

            return response()->json([
                "status" => "success",
                "message" => "Employee Updated Successfully!",
                'employee' => $employee
              ], 200);

    }

    public function employeeDisabled($id)
    {
        $employee=Employee::where('id',$id)->get();
        return $employee;

    }

}
