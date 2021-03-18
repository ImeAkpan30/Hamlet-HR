<?php

namespace App\Http\Controllers;

use App\Plan;
use App\User;
use App\Payment;
use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SubscriptionRequest;

class SubscriptionController extends Controller
{
    public function subscribe(Request $requestData)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);
         }

        $this->validate($requestData,[
            "duration"=>"required",
            "plan_id" => "required|exists:plans,id",
        ]);

        $data = (object)$requestData;

        $date = Carbon::now()->format('Y-m-d H:i:s');

        $plan = Plan::where("id", $data->plan_id)->first();

        if (!$plan){
            return [
                "status_code" => 404,
                "message" => "Plan not found"
            ];
        }

        $amount = ($plan->price * $data->duration);

        $subscription = Subscription::create([
            "user_id" => auth()->user()->id,
            "plan_id" => $plan->id,
            "duration" => $data->duration,
            "amount" => $amount,
            "start_at" => $date,
            "expired_at" => $date,
            "status"=> 'pending'
        ]);

        if (!$subscription){
            return [
                "status_code" =>422,
                "message" => "Invalid details"
            ];
        }

         // create payment instance


         $user = User::where('id',Auth::user()->id)->first();
         $subscription = Subscription::where('id',$data->plan_id)->first();

         $payment = Payment::create([
            'user_id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'type' => 'Subscription',
            'type_id' => $subscription->id,
            'reference' => 'HAM-'.strtolower(uniqid()),
            'currency' => 'NGN',
            'amount' => $subscription->amount,
            'channel' => 'card',
            'status' => 'pending',
            'gateway' => 'PAYSTACK',
            'transaction_date' => $date,
         ]);

        return response()->json([
            'subscription' => $subscription,
            'payment_detail' => $payment
        ], 200);
     }

     public function listUserSubscription(){
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);
         }

         $subscriptions = Subscription::orderBy('created_at','DESC')->paginate(5);

        return response()->json([
            'subscriptions' => $subscriptions
        ], 200);

    }

    public function mySubscriptions(){
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);
         }

         $subscriptions = Subscription::ofUser()->orderBy("created_at","DESC")->paginate(5);

        return response()->json([
            'subscriptions' => $subscriptions
        ], 200);

    }
}
