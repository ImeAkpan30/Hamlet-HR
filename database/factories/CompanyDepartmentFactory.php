<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CompanyDepartment;
use Faker\Generator as Faker;

$sampleDepartments = [
    'Cleaning',
    'Engineering',
    'Data Science',
    'Human Resources',
    'User Experience',
    'Automation',
    'Sales'
];

$factory->define(CompanyDepartment::class, function (Faker $faker) use ($sampleDepartments) {
    return [
        'name' => collect($sampleDepartments)->random(),
    ];
});
