<?php

namespace App\Http\Controllers;

use App\Employee;
use App\JobDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobDetailController extends Controller
{
    public function addJobDetails(Request $request){
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }
        $this->validate($request,[
            'employment_type'=>'required',
            'job_title'=>'required',
            'salary'=>'required',
            'date_hired'=>'required|date',
            'description'=>'required',
            'department'=>'required',
            'employment_classification'=>'required',
            'job_category'=>'required',
            'work_location'=>'required',
        ]);

        // $employee_id = Employee::where('user_id',Auth::user()->id)->pluck('id')->first();
        $jobDetail = new JobDetail();
        $jobDetail->employment_type = $request->input('employment_type');
        $jobDetail->employee_id = $request->input('employee_id');
        $jobDetail->job_title = $request->input('job_title');
        $jobDetail->salary = $request->input('salary');
        $jobDetail->date_hired = $request->input('date_hired');
        $jobDetail->description = $request->input('description');
        $jobDetail->department = $request->input('department');
        $jobDetail->job_category = $request->input('job_category');
        $jobDetail->employment_classification = $request->input('employment_classification');
        $jobDetail->work_location = $request->input('work_location');


            $jobDetail->save();
            return response()->json([
                "status" => "success",
                "message" => "Job Details Added Successfully!"
                ,$jobDetail
             ], 200);
    }

    public function updatejobDetails(Request $request,$id){
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }
        $this->validate($request,[
            'employment_type'=>'required',
            'job_title'=>'required',
            'salary'=>'required',
            'date_hired'=>'required|date',
            'description'=>'required',
            'department'=>'required',
            'employment_classification'=>'required',
            'job_category'=>'required',
            'work_location'=>'required',
        ]);

//         $employee_id = Employee::where('user_id',Auth::user()->id)->pluck('id')->first();
        $jobDetail = JobDetail::find($id);
        $jobDetail->employment_type = $request->input('employment_type');
        $jobDetail->employee_id = $request->input('employee_id');
        $jobDetail->job_title = $request->input('job_title');
        $jobDetail->salary = $request->input('salary');
        $jobDetail->date_hired = $request->input('date_hired');
        $jobDetail->description = $request->input('description');
        $jobDetail->department = $request->input('department');
        $jobDetail->job_category = $request->input('job_category');
        $jobDetail->employment_classification = $request->input('employment_classification');
        $jobDetail->work_location = $request->input('work_location');


            $jobDetail->save();
            return response()->json([
                "status" => "success",
                "message" => "Job Details Updated Successfully!"
              ], 200);

    }
}
