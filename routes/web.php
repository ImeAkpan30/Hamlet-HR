<?php

use App\Events\Notifications;
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

// socialite google
Route::get('/google', 'GoogleController@google');
Route::get('/google/callback', 'GoogleController@callback');

// deploy status
Route::get('/deploy', function () {
    $rootDir = base_path();
    exec("cd $rootDir && git pull origin master", $output);
    dump($output);
});



// testing brodcasting events
Route::get('/events', function () {
   return view('Test');
});


Route::get('/test/{p1}/{p2}', function ($p1,$p2) { 
    event(new Notifications($p1,$p2));
    dump([$p1,$p2]);
});
