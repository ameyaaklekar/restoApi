<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
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

    public function getUser(Request $request)
    {
        $user = $request->user();
        $user['permissions'] = $request->user()->allPermissions();
        $user['roles'] = $user->roles;
        $user['company'] = $user->company;
        return $user;
    }
}
