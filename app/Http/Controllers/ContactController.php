<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function saveContact(Request $request) {


        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        $contact = new Contact;

        $contact->firstname = $request->firstname;
        $contact->lastname = $request->lastname;
        $contact->email = $request->email;
        $contact->message = $request->message;

        $contact->save();
            return response()->json([
                "status" => "success",
                "message" => "Thank you for contacting us!",
                'contact' => $contact
              ], 200);

    }

}
