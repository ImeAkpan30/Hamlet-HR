<?php

namespace App\Http\Controllers;

use App\Plan;
use function ucfirst;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreatePlanRequest;
use App\Http\Requests\UpdatePlanRequest;

class PlanController extends Controller
{
    protected $planModel;

    public function __construct(Plan $planModel)
    {
        $this->planModel=$planModel;
    }

    public function listPlan(){

        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);
         }

         $plans = Plan::all();

        return response()->json([
            'plans' => $plans
        ], 200);
    }

    public function createPlan(CreatePlanRequest $request){

        $plan = $this->planModel->create([
            "name" => ucfirst($request->name),
            "description"=> $request->description,
            "price" => $request->price,
            "currency" => $request->currency,
        ]);
        if (!$plan){
            return response("Invalid inputs",422);
        }else{
            $plan->save();
        }
        return response()->json([
            'plan' => $plan
        ], 200);
    }

    public function updatePlan(UpdatePlanRequest $request, $id){
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);
         }

        $data = (object) $request;

        $plan = Plan::find($id);
        if (!$plan){
            return ([
                "status_code"=>404,
                "message"=>"Error updating plan"
            ]);
        }
        $plan->update([
            "price"=>$data->price,
            "name"=>$data->name,
            "currency"=>$data->currency,
            "description"=>$data->description,
        ]);

        return response()->json([
            'plan' => $plan
        ], 200);
    }

    public function deletePlan($id){
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized!'], 401);
         }

        $plan = Plan::find($id);
        $plan->delete();

        return response()->json([
            'message' => 'Plan deleted successfully!'
        ], 200);
    }
}
