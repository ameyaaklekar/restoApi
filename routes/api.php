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

    Route::group(['prefix' => 'user'], function() {
        Route::get('/', 'UserController@getUser');
    
        Route::put('user/update', 'UserController@updateUser');
    });

    Route::group(['prefix' => 'employee'], function() {     
        Route::post('add', 'Employee\EmployeeController@addEmployee');
    
        Route::get('all', 'Employee\EmployeeController@getAllEmployees');
    
        Route::get('{employeeId}/edit', 'Employee\EmployeeController@getEmployee');
    
        Route::put('update', 'Employee\EmployeeController@updateEmployee');

        Route::patch('update/change-status', 'Employee\EmployeeController@changeStatus');
    });

    Route::group(['prefix' => 'roles'], function() {     
        Route::get('/','Roles\RolesController@getRoles');
    
        Route::get('permission/{role}','Roles\RolesController@getRolesPermission');
    });

    Route::group(['prefix' => 'permissions'], function() {     
        Route::get('/','Permissions\PermissionsController@getPermissions');
    });
   
    Route::group(['prefix' => 'suppliers'], function() {     
        Route::post('add', 'Suppliers\SuppliersController@addSupplier');
    
        Route::get('all', 'Suppliers\SuppliersController@getAllSupplier');
    
        Route::put('update/change-status', 'Suppliers\SuppliersController@changeStatus');
    
        Route::put('update', 'Suppliers\SuppliersController@updateSupplier');
    
        Route::get('{supplierId}/edit', 'Suppliers\SuppliersController@getSupplier');
    });

    Route::group(['prefix' => 'company'], function() {
        Route::get('employees', 'Company\CompanyController@getEmployees');
    });

});