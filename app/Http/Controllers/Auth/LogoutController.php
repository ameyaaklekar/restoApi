<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    protected function logout(Request $request)
    {
        $request->user()->token()->revoke();
    }
}
