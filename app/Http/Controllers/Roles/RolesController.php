<?php

namespace App\Http\Controllers\Roles;

use App\Model\Role;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RolesController extends Controller
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

    public function getRoles() 
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        if ($user->hasRole('superAdmin', $user->company->name)) {
            return Role::all();
        } else {
            return Role::whereRaw('name != ? ', ['superAdmin'])->get();
        }
    }

    public function getRolesPermission(Request $request, $role)
    {
        $role = Role::where('name', $role)->first();
        return $role->permissions;
    }
}
