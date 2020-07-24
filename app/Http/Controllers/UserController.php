<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $user = Auth::user();
        $user['permissions'] = $request->user()->allPermissions();
        $user['roles'] = $user->roles;
        $user['company'] = $user->company;
        return $user;
    }

    public function updateUser(Request $request) 
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        Validator::make($request->all(), [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'countryCode' => ['required', 'digits_between:1,3'],
            'phoneNumber' => ['required', 'digits_between:5,12'],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email,{$user->id}"],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'postalCode' => ['required', 'string', 'max:255'],
        ])->validate();

        // Save user to database
        $user->update([
            'first_name' => $request['firstName'],
            'last_name' => $request['lastName'],
            'country_code' => $request['countryCode'],
            'phone_number' => $request['phoneNumber'],
            'email' => $request['email'],
            'address' => $request['address'],
            'city' => $request['city'],
            'state' => $request['state'],
            'country' => $request['country'],
            'postal_code' => $request['postalCode']
        ]);

        $user['permissions'] = $request->user()->allPermissions();
        $user['roles'] = $user->roles;
        $user['company'] = $user->company; 

        return $user;
    }

    public function addEmployee(Request $request) {

    }
}
