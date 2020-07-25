<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Model\Role;
use Illuminate\Http\Request;

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
        return Role::whereRaw('name != ? ', ['superAdmin'])->get();
    }

    public function getRolesPermission(Request $request)
    {
        $role = Role::where('name', $request['role'])->first();
        return $role->permissions;
    }
}
