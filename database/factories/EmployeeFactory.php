<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Url;
use App\Employee;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Employee::class, function (Faker $faker) {

    return [
        'user_id' => rand(5,15),
        'first_name' => $faker->name,
        'other_names' => '',
        'gender' => $faker->gender,
        'profile_pic' => asset('images/FOSSA.jpg'),
        'dob' => $faker->date,
        'address' => $faker->address,
        'city' => $faker->city,
        'qualification' => 'BSc',

    ];
});
