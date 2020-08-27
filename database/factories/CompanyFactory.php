<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$logos = [
    'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png',
    'https://phpsandbox.io/img/psb_logo_white.32c910d7.png',
    'https://cdn.shopify.com/shopifycloud/supplier_portal/assets/admin-fresh/shared/shopify-logo-color-inverted-cb1e563e6783595c4c57b1974348c5c420a9c74eea48c5492a1be8d82bb2b809.svg',
];

$factory->define(Company::class, function (Faker $faker) use ($logos) {
    return [
        'company_name' => Str::ucfirst(Str::beforeLast($website = $faker->domainName, '.')),
        'company_email' => $faker->companyEmail,
        'company_address' => $faker->address,
        'company_phone' => $faker->phoneNumber,
        'no_of_employees' => random_int(2, 100),
        'city' => $faker->city,
        'state' => $faker->state,
        'zip_code' => $faker->postcode,
        'company_website' => $website,
        'company_logo' => collect($logos)->random(),
        'services' => $faker->sentence('10')
    ];
});
