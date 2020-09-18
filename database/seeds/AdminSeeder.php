<?php

use App\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $userExist=User::where('email','hamlethr2020@gmail.com')->exit();
        // if ( $userExist ) {
            User::create([
                'username' => 'Admin',
                'email' => 'hamlethr2020@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make("Hamlet2020"),
                'role' => 'admin',
                'remember_token' => Str::random(10)
            ]);
        // } else {

        //     User::u([
        //         'username' => 'Admin',
        //         'email' => 'hamlethr2020@gmail.com',
        //         'email_verified_at' => now(),
        //         'password' => Hash::make("Hamlet2020"),
        //         'role' => 'admin',
        //         'remember_token' => Str::random(10)
        //     ]);
        // }


    }
}

