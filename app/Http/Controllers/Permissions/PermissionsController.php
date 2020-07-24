<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use App\Model\Permission;
use Illuminate\Http\Request;
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
        $user = Auth::user();

        if ($user->hasRole('superAdmin')) {
            return Permission::all();
        } else {
            return Permission::whereNotIn('name', ['addRoles', 'updateRoles', 'deleteRoles'])->get();
        }
    }
}
