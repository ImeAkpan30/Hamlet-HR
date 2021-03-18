<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PlanTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('plans')->count() == 0){
            $this->seedPlans();
        }
    }

    public function seedPlans(){

        $free = array(
            ' - Maximum of 5 employees ',
            ' - No Payroll Support',
            ' - Access to customer support'
        );

        $premium = array(
            ' - Maximum of 50 employees',
            ' - Payroll Support',
            ' - 24 hours of free maintenance support',
            ' - 24 hours customer support'
        );

        $gold = array(
            ' - Unlimited number of employees',
            ' - Payroll Support',
            ' - 24 hours of free maintenance support',
            ' - 24 hours customer support'
        );

        $time = Carbon::parse('UTC')->now();

        $plans = [
            [
                'name'=>'Free',
                'description'=> implode(", ", $free),
                'price'=> '0',
                'currency' => 'NGN',
                'created_at'=>$time,
                'updated_at'=>$time
            ],

            [
                'name'=>'Premium',
                'description'=> implode(", ", $premium),
                'price'=> 1500,
                'currency' => 'NGN',
                'created_at'=>$time,
                'updated_at'=>$time
            ],

            [
                'name'=>'Gold',
                'description' => implode(",", $gold),
                'price' => 2500,
                'currency' => 'NGN',
                'created_at'=>$time,
                'updated_at'=>$time
            ]
        ];

        DB::table('plans')->insert($plans);
    }
}
