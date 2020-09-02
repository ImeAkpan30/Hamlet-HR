<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome', ['emails' => DatabaseSeeder::managerEmails()]);
});

Route::get('/deploy', function () {
    $rootDir = base_path();
    exec("cd $rootDir && git pull origin master", $output);
    dump($output);
});
