<?php

namespace App\Http\Controllers\Permissions;

use App\Model\User;
use App\Model\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PermissionsController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getPermissions()
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);
        
        if ($user->hasRole('superAdmin', $user->company->name)) {
            return Permission::all();
        } else {
            return Permission::whereNotIn('name', ['addRoles', 'updateRoles', 'deleteRoles'])->get();
        }
    }
}
