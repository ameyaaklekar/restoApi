<?php

namespace App\Http\Controllers\Auth;

use App\Model\Role;
use App\Model\User;
use App\Company\Company;
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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'company.name' => ['required', 'string', 'max:255', 'unique:company'],
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'countryCode' => ['required', 'digits_between:1,3'],
            'phoneNumber' => ['required', 'digits_between:5,12'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Model\User
     */
    protected function create(array $data)
    {
        $company = Company::create([
            'name' => $data['company']['name'],
            'display_name' => $data['company']['name']
        ]);

        $user = User::create([
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'country_code' => $data['countryCode'],
            'phone_number' => $data['phoneNumber'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'company_id' => $company->id
        ]);

        $admin = Role::where('name', 'admin')->first();
        $user->attachRole($admin, $company);

        return $user;
    }
}
