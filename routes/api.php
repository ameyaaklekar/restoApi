<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Permissions\PermissionsController;
use App\Http\Controllers\Roles\RolesController;
use App\Http\Controllers\Suppliers\SuppliersController;
use App\Http\Controllers\UserController;
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

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);
Route::post('logout', [LogoutController::class, 'logout'])->middleware('auth:api');

Route::middleware('auth:api')->group(function() {

    Route::group(['prefix' => 'user'], function() {
        Route::get('/', [UserController::class, 'getUser']);
    
        Route::put('/', [UserController::class, 'updateUser']);
    });

    Route::group(['prefix' => 'employee'], function() {     
        Route::post('/', [EmployeeController::class, 'addEmployee']);
    
        Route::get('/', [EmployeeController::class, 'getAllEmployees']);
    
        Route::get('{employeeId}', [EmployeeController::class, 'getEmployee']);
    
        Route::put('/', [EmployeeController::class, 'updateEmployee']);

        Route::patch('change-status', [EmployeeController::class, 'changeStatus']);
    });

    Route::group(['prefix' => 'roles'], function() {     
        Route::get('/', [RolesController::class, 'getRoles']);
    
        Route::get('permission/{role}', [RolesController::class, 'getRolesPermission']);
    });

    Route::group(['prefix' => 'permissions'], function() {     
        Route::get('/', [PermissionsController::class, 'getPermissions']);
    });
   
    Route::group(['prefix' => 'suppliers'], function() {     
        Route::post('/', [SuppliersController::class, 'addSupplier']);
    
        Route::get('/', [SuppliersController::class, 'getAllSupplier']);
    
        Route::patch('change-status', [SuppliersController::class, 'changeStatus']);
    
        Route::put('/', [SuppliersController::class, 'updateSupplier']);
    
        Route::get('{supplierId}', [SuppliersController::class, 'getSupplier']);
    });

    Route::group(['prefix' => 'company'], function() {
        Route::get('employees', [CompanyController::class, 'getEmployees']);
    });

});