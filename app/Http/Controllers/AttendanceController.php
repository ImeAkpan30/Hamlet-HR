<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;

class AttendanceController extends Controller
{
    public function addAttendance(Request $request){
        $this->validate($request,[
            'attendance_status'=>'required',
            'date'=>'required',
        ]);

        $attendance = new Attendance;
        $attendance->attendance_status = $request->input('attendance_status');
        $attendance->employee_id = $request->input('employee_id');
        $attendance->date = $request->input('date');

            $attendance->save();
            return response()->json([
                "status" => "success",
                "message" => "Attendance Added Successfully!"
              ], 200);
    }
}
