<?php

use App\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'hamlethr2020@gmail.com'],
            [
            'username' => 'Admin',
            'email' => 'hamlethr2020@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make("Hamlet2020"),
            'role' => 'admin',
            'remember_token' => Str::random(10)
        ]);
    }
}

