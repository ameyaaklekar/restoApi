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

    Route::post('suppliers/add', 'Suppliers\SuppliersController@addSupplier');

    Route::get('suppliers/all', 'Suppliers\SuppliersController@allSupplier');

    Route::put('suppliers/update/change-status', 'Suppliers\SuppliersController@changeStatus');

    Route::put('suppliers/update', 'Suppliers\SuppliersController@updateSupplier');

    Route::get('suppliers/{supplierId}/edit', 'Suppliers\SuppliersController@getSupplier');


});