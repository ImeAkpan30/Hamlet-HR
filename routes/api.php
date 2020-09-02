<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('signup', 'AuthController@register')->name('signup');
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout');
    Route::get('admin', 'AuthController@getAuthUser');
});

Route::post('/company', 'CompanyController@addCompany');
Route::put('/company/{id}', 'CompanyController@updateCompany');

Route::get('/department/{id}', 'CompanyDepartmentController@getDepartments');
Route::post('/department', 'CompanyDepartmentController@addDepartment');

Route::put('/department/{id}', 'CompanyDepartmentController@updateDepartment');

Route::post('/profile', 'ProfileController@addProfile');
Route::put('/profile/{id}', 'ProfileController@updateProfile');



Route::get('/employee', 'EmployeeController@getEmployees');
Route::post('/employee', 'EmployeeController@addEmployee');
Route::get('/employee/{id}', 'EmployeeController@getEmployee');
Route::get('/employees/{id}', 'EmployeeController@getSingleEmployee');
Route::put('/employee/{id}', 'EmployeeController@updateEmployee');
Route::post('/employee/disabled/{id}', 'EmployeeController@employeeDisabled');

Route::post('/job-details', 'JobDetailController@addJobDetails');
Route::put('/job-details/{id}', 'JobDetailController@UpdatejobDetails');

Route::post('/contact-info', 'ContactInfoController@addContactInfo');
Route::put('/contact-info/{id}', 'ContactInfoController@updateContactInfo');
Route::post('/attendance', 'AttendanceController@addAttendance');
