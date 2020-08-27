<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CompanyDepartment;
use Faker\Generator as Faker;

$sampleDepartments = DatabaseSeeder::departments();

$factory->define(CompanyDepartment::class, function (Faker $faker) use ($sampleDepartments) {
    return [
        'name' => collect($sampleDepartments)->random(),
    ];
});
