<?php

use Illuminate\Http\Request;
use App\Events\Notifications;
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
    'middleware'=>'is-ban',
    'prefix' => 'auth'
], function ($router) {
    Route::post('signup', 'AuthController@register')->name('signup');
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('logout', 'AuthController@logout');
    Route::get('admin', 'AuthController@getAuthUser');
    Route::get('userRevoke/{id}', 'AdminController@revoke');
    Route::post('userBan', 'AdminController@ban');
});

// Admin Routes
Route::post('/admin/login', 'AdminController@login');
Route::post('/admin/logout', 'AdminController@logout');
Route::get('/admin/profile', 'AdminController@getAdmin');
Route::get('/admin/users', 'AdminController@getUsers');
Route::get('/admin/company', 'AdminController@getCompanies');
Route::get('/admin/contact', 'AdminController@getAllContacts');
Route::get('/admin/contact/{id}', 'AdminController@getContactById');
Route::delete('/admin/deleteContact/{id}', 'AdminController@deleteContact');
Route::delete('/admin/deleteUser/{id}', 'AdminController@deleteUser');
Route::get('/admin/user/{email}', 'AdminController@getUserByEmail');
Route::get('/admin/allUsers', 'AdminController@getAllUsers');
Route::get('/admin/chatUsers', 'AdminController@getChatUsers');
Route::get('/admin/allCompanies', 'AdminController@getAllCompanies');
Route::get('/admin/ban/users', 'AdminController@getBannedUsers');
Route::get('/admin/active/users', 'AdminController@getActiveUsers');
Route::get('/admin/allCompanies', 'AdminController@getAllCompanies');
Route::get('/admin/company/{email}', 'AdminController@getCompanyByEmail');
Route::post('/admin/notify/users', 'NotifyController@notifyUsers');
Route::get('/update/notify', 'NotifyController@getNoticeUpdate');

// Chats
Route::post('/chat', 'ChatController@chat');
Route::get('/chat/view/{chat}', 'ChatController@view');

// Company Routes
Route::post('/company', 'CompanyController@addCompany');
Route::put('/company/{id}', 'CompanyController@updateCompany');

// Department Routes
Route::get('/department/{id}', 'CompanyDepartmentController@getDepartments');
Route::post('/department', 'CompanyDepartmentController@addDepartment');
Route::put('/department/{id}', 'CompanyDepartmentController@updateDepartment');

// Manager Profile Routes
Route::post('/profile', 'ProfileController@addProfile');
Route::put('/profile/{id}', 'ProfileController@updateProfile');

// Employee Routes
Route::get('/employee', 'EmployeeController@getEmployees');
Route::post('/employee', 'EmployeeController@addEmployee');
Route::get('/employee/{id}', 'EmployeeController@getEmployee');
Route::get('/employees/{id}', 'EmployeeController@getSingleEmployee');
Route::put('/employee/{id}', 'EmployeeController@updateEmployee');
Route::post('/employee/disabled/{id}', 'EmployeeController@employeeDisabled');

// Job Details Routes
Route::post('/job-details', 'JobDetailController@addJobDetails');
Route::put('/job-details/{id}', 'JobDetailController@UpdatejobDetails');

// Contact Info Routes
Route::post('/contact-info', 'ContactInfoController@addContactInfo');
Route::put('/contact-info/{id}', 'ContactInfoController@updateContactInfo');
Route::post('/attendance', 'AttendanceController@addAttendance');

Route::post('contact-us', 'ContactController@saveContact');


