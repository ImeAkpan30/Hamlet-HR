<?php

namespace App\Http\Controllers;

use App\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifyController extends Controller
{
    public function notifyUsers(Request $request) {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required',
        ]);

        $notice = new Notify();
        $notice->title = $request->input('title');
        $notice->body = $request->input('body');


            $notice->save();
            return response()->json([
                "status" => "success",
                "message" => "Notice Sent Successfully!",
                'notice' => $notice
              ], 200);
    }

    public function getNoticeUpdate()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);
         }
         $notice = Notify::orderBy('id','DESC')->get();
        return response()->json([
            'notice' => $notice
        ], 200);
    }
}
