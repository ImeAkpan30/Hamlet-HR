<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ContactInfo;
use Faker\Generator as Faker;

$factory->define(ContactInfo::class, function (Faker $faker) {
    return [
        'phone' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'emergency_contact' => $faker->phoneNumber
    ];
});
