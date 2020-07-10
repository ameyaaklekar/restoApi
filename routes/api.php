<?php

use App\Model\Role;
use App\Model\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    // $admin = Role::create([
    //     'name' => 'owner',
    //     'display_name' => 'User Administrator', // optional
    //     'description' => 'User is allowed to manage and edit other users', // optional
    // ]);
    
    // $createPost = Permission::create([
    //     'name' => 'create-post',
    //     'display_name' => 'Create Posts', // optional
    //     'description' => 'create new blog posts', // optional
    //     ]);
        
    // $admin->attachPermission($createPost);

    // $request->user()->attachRole($admin);
    $user = $request->user();
    $user['permissions'] = $request->user()->allPermissions();
    return $user;
});
