<?php

namespace App\Http\Controllers\Auth;

use App\Model\Role;
use App\Model\User;
use Illuminate\Http\Request;
use App\Model\Company\Company;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function register(Request $request)
    {
        Validator::make($request->all(), [
            'company.name' => ['required', 'string', 'max:255', 'unique:company'],
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'countryCode' => ['required', 'digits_between:1,3'],
            'phoneNumber' => ['required', 'digits_between:5,12'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $company = Company::create([
            'name' => $request['company']['name'],
            'display_name' => $request['company']['name']
        ]);

        $user = User::create([
            'first_name' => $request['firstName'],
            'last_name' => $request['lastName'],
            'country_code' => $request['countryCode'],
            'phone_number' => $request['phoneNumber'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'company_id' => $company->id
        ]);

        $admin = Role::where('name', 'admin')->first();
        $user->attachRole($admin, $company);

        return $user;
    }
}
