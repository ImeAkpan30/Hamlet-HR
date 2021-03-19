<?php

namespace App\Http\Controllers;

use App\Plan;
use App\User;
use Paystack;
use App\Payment;
use App\Subscription;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect; 

class PaymentController extends Controller
{

    // public function __construct() {
    //     $this->middleware('auth:api');
    // }
    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
          
        if(request()->metadata)  
        
        // validate subscribtion data   
        $this->validate(request(),[ 
            'plan_id'=>'required|integer',   
            'amount'=>'required|integer', 
            'duration'=>'required|integer', 
            'user_id'=>'required|integer', 
        ]);
          
        $date=request()->duration * 30; //get the month and make it days
        $newDate=now()->addDays($date); //callculate expired date from retrieved month  
        $plan = Plan::where("id", request()->plan_id)->first(); //get and retrive plan

        if (!$plan){
            return [
                "status_code" => 404,
                "message" => "Plan not found"
            ];
        }

        $amount = ($plan->price * request()->duration); 

        // create a subscribtion plan with pending status  
        Subscription::create([
           'user_id'=>request()->user_id,
           'plan_id'=>request()->plan_id, 
           'duration'=>request()->duration, 
           'amount'=>$amount, 
           'start_at'=>now(), 
           'expired_at'=>$newDate, 
           'status'=>'pending',   
        ]);

        // Redirect to Payment URL Paystack
        try{ 
            return Paystack::getAuthorizationUrl()->redirectNow(); 
        }catch(\Exception $e) {
            return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
        
       }
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        // Retrive Payment Details from paystack
        $paymentDetails = Paystack::getPaymentData();  
        $this->UpdatePayment($paymentDetails);
    }


     /**
     * save Paystack payment information in database
     * @return void
     */
    public function UpdatePayment($data)
    {   
        
        
        $metadata=$data['data']['metadata']; 
        $type_id=Subscription::where('user_id',$metadata['user_id'])
        ->orderBy('id', 'desc')
        ->first()->id; 
        
        // Store Payment  
        $payment= Payment::create([
            'user_id'=>$metadata['user_id'],
            'type'=> 'Subscription',
            'type_id'=>$type_id,
            'reference'=>$data['data']['reference'],
            'currency'=>$data['data']['currency'],
            'channel'=>$data['data']['channel'],
            'amount'=>$data['data']['amount'],
            'status'=>$data['data']['status'], 
            'gateway'=>"PAYSTACK", 
            'transaction_date'=>$data['data']['transaction_date'],
        ]);
 
          // update the subscribtion plan previously created with active status
          Subscription::where('user_id',$metadata['user_id'])
          ->update([
            'status'=>'active'
          ]);  

    }

    public function UpdatePaymentMobile(Request $data)
    {
        // get and store Payment from Mobile Paystack API's....
        $this->validate($data,[
            'reference'=>'required',
            'currency'=>'required',
            'chanel'=>'required',
            'amount'=>'required',
            'status'=>'required', 
            'transaction_date'=>'required',
        ]);
        $payment=Payment::create([
            'user_id'=>Auth::user()->id,
            'reference'=>$data['reference'],
            'currency'=>$data['currency'],
            'type'=> 'Subscription',
            'type_id'=> $data->metadata['type_id'],
            'chanel'=>$data['channel'],
            'amount'=>$data['amount'],
            'status'=>$data['status'], 
            'getway'=>"PAYSTACK",  
            'transaction_date'=>$data['transaction_date'],
        ]);
          // update the subscribtion plan previously created with active status
          Subscription::where('user_id',$data->data->metadata['user_id'])
          ->update([
            'status'=>'active'
          ]); 
        $info=[
            'payment_status'=>$payment,
            'message'=>"succesful",
        ];
        return response()->json($info, 200);
    }
}


