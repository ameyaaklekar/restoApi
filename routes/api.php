<?php

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

Route::middleware('auth:sanctum')->group(function() {

    Route::get('user', 'UserController@getUser');
    Route::put('user/update', 'UserController@updateUser');
    
    Route::post('employee/add', 'Employee\EmployeeController@addEmployee');

    Route::get('roles','Roles\RolesController@getRoles');

    Route::get('roles/permission/{role}','Roles\RolesController@getRolesPermission');

    Route::get('permissions','Permissions\PermissionsController@getPermissions');
});