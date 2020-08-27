<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\JobDetail;
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

$sampleDepartments = DatabaseSeeder::departments();

$factory->define(JobDetail::class, function (Faker $faker) use ($sampleDepartments) {
    return [
        'employee_id' => rand(5,15),
        'employment_type' => collect(['Employee', 'Contingent Worker'])->random(),
        'job_title' => $faker->name,
        'salary' => random_int(100000, 10000000),
        'date_hired' => $faker->dateTimeBetween('1990-01-01', '2012-12-31')->format('Y-m-d'),
        'description' => $faker->paragraph,
        'department' => collect($sampleDepartments)->random(),
        'employment_classification' => collect(['Full Time', 'Part Time', 'Intern'])->random(),
        'job_category' => collect(['Executive Officer', 'Sales', 'Human Resources', 'Engineering'])->random(),
        'work_location' => $faker->city,
    ];
});

