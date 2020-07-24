<?php

namespace App\Http\Controllers\Employee;

use App\Model\User;
use Illuminate\Http\Request;
use App\Constants\Permission as PermissionConst;
use App\Http\Controllers\Controller;
use App\Model\Company\Company;
use App\Model\Permission;
use App\Model\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
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

    public function addEmployee(Request $request) {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        if ($user->isAbleTo(PermissionConst::ADD_EMPLOYEE, $user->company->name)) {

            $rules = [
                'firstName' => ['required', 'string', 'max:255'],
                'lastName' => ['required', 'string', 'max:255'],
                'countryCode' => ['required', 'digits_between:1,3'],
                'phoneNumber' => ['required', 'digits_between:5,12'],
                'email' => ['required', 'string', 'email', 'max:255', "unique:users"],
                'address' => ['string', 'max:255'],
                'city' => ['string', 'max:255'],
                'state' => ['string', 'max:255'],
                'country' => ['string', 'max:255'],
                'postalCode' => ['string', 'max:255'],
                'role' => ['required', 'string', 'max:50', 'exists:roles,name'],
                'permissions' => ['required', 'array'],
            ];

            $messages = [
                'required' => 'The :attribute is required.',
                'max' => 'The :attribute is too long.',
                'unique' => 'User :attribute already exist.',
                'role.exists' => 'Role does not exist. Please select the correct role.',
            ];

            Validator::make($request->all(), $rules, $messages)->validate();

            $role = Role::where('name', $request['role'])->first();
            $rolePermissions = (array) $role->permissions;
            
            $additionalPermissions = [];

            foreach ($rolePermissions as $rolePermission) {
                foreach ($request['permissions'] as $permission) {
                    if (!in_array($permission, array_column($rolePermission, 'name'))) {
                        $additionalPermissions[] = $permission;
                    }
                }
            }

            $newUser = User::create([
                'first_name' => $request['firstName'],
                'last_name' => $request['lastName'],
                'country_code' => $request['countryCode'],
                'phone_number' => $request['phoneNumber'],
                'email' => $request['email'],
                'password' => Hash::make(env('NEW_USER_PASSWORD', '')),
                'address' => $request['address'],
                'city' => $request['city'],
                'state' => $request['state'],
                'country' => $request['country'],
                'postal_code' => $request['postalCode'],
                'company_id' => $user->company->id
            ]);

            $newUser->attachRole($role, $user->company);
            
            if (!empty($additionalPermissions)) {

                foreach ($additionalPermissions as $permission) {

                    if ($objPermission = Permission::where('name', $permission)->first()) {
                        $newUser->attachPermission($objPermission, $user->company);
                    }

                }

            }

            return $newUser;
        }
    }
}
