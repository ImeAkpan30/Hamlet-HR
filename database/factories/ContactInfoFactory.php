<?php

/** @var Factory $factory */

use App\ContactInfo;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(ContactInfo::class, function (Faker $faker) {
    return [
        'phone' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'emergency_contact' => $faker->phoneNumber
    ];
});
