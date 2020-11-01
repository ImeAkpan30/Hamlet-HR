<?php

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;
use App\Events\Notifications;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }

         $this->validate($request,[
            'user_id'=>'required',
            'friends_id'=>'required',
            'photo'=>'nullable|image|mimes:jpeg,png,svg,jpg',
            'message'=>'nullable'
        ]);

       if( $request->photo !='' || $request->message !=''){
        $chat = new Chat();
        $chat->user_id = $request->input('user_id');
        $chat->friends_id = $request->input('friends_id');
        $chat->message = $request->input('message');

        if($request->hasFile('photo')){
            $file = $request->file('photo');

            $file->move(public_path(). '/chats/', $file->getClientOriginalName());
            $url = URL::to("/") . '/chats/'. $file->getClientOriginalName();
            $chat->photo = $url;
        }else{
            $chat->photo = null;
        }

        if($chat){
            $chat->save();
             // events
             event(new Notifications([$chat,Auth::user()],'Chat'));
            return response()->json([
                "status" => "success",
                "message" => "Chat  Successfully!",
                'chat' => $chat
              ], 200);
        }
       }

    }

    public function view($chat)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);

         }
        $chats = Chat::where(function($q) use($chat)
        {
            $q->where('user_id', auth()->user()->id)
            ->where('friends_id',$chat);
        })
        ->orWhere(function($q) use($chat)
        {
            $q->where('friends_id', auth()->user()->id)
            ->where('user_id',$chat);
        })->with('user.profile')
        ->get();

        return response()->json($chats, 200);
    }
}
