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
Route::put('/updatecompany/{id}', 'CompanyController@updateCompany');

Route::get('/departments', 'CompanyDepartmentController@getDepartments');
Route::post('/department', 'CompanyDepartmentController@addDepartment');

Route::put('/updatedepartment/{id}', 'CompanyDepartmentController@updateDepartment');

Route::post('/profile', 'ProfileController@addProfile');

Route::get('/employees', 'EmployeeController@getEmployees');
Route::post('/employee', 'EmployeeController@addEmployee');
Route::get('/employees/{id}', 'EmployeeController@getEmployee');
Route::put('/employee/{id}', 'EmployeeController@updateEmployee');
Route::post('/employeedisabled/{id}', 'EmployeeController@employeeDisabled');

Route::post('/jobdetails', 'JobDetailController@addJobDetails');
Route::put('/updatejobdetails/{id}', 'JobDetailController@UpdatejobDetails');

Route::post('/contactinfo', 'ContactInfoController@addContactInfo');
Route::put('/updatecontactinfo/{id}', 'ContactInfoController@updateContactInfo');

Route::post('/attendance', 'AttendanceController@addAttendance');
