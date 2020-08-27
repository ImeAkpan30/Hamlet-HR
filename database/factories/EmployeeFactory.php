<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
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

$profilePictures = [
    'http://www.hotavatars.com/wp-content/uploads/2019/01/I80W1Q0.png',
    'https://koolinus.files.wordpress.com/2019/03/avataaars-e28093-koolinus-1-12mar2019.png',
    'http://happyfacesparty.com/wp-content/uploads/2019/06/avataaars-Frances.png',
];

$sampleQualigications = [
    'OND', 'HND', 'Degree', 'Masters', 'PhD'
];

$factory->define(Employee::class, function (Faker $faker) use ($sampleQualigications, $profilePictures) {
    return [
        'user_id' => rand(5,15),
        'first_name' => $faker->name,
        'other_names' => '',
        'gender' => collect(['male', 'female'])->random(),
        'profile_pic' => collect($profilePictures)->random(),
        'dob' => $faker->date,
        'address' => $faker->address,
        'city' => $faker->city,
        'qualification' => collect($sampleQualigications)->random(),
    ];
});
