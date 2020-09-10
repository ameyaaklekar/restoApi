<?php

namespace App\Http\Controllers\Employee;

use App\Model\Role;
use App\Model\User;
use App\Model\Permission;
use Illuminate\Http\Request;
use App\Model\Company\Company;
use App\Rules\CheckPermissions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Constants\Permission as PermissionConst;

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

        $validationRule = [
            'permission' => ['required', 'string', new CheckPermissions($user)] 
        ];

        Validator::make(['permission' => PermissionConst::UPDATE_SUPPLIER], $validationRule)->validate();

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

        $role = Role::where('name', trim(htmlspecialchars($request['role'])))->first();
        $rolePermissions = (array) $role->permissions;
        
        $additionalPermissions = [];

        foreach ($rolePermissions as $rolePermission) {
            foreach ($request['permissions'] as $permission) {
                if (!in_array($permission, array_column($rolePermission, 'name'))) {
                    $additionalPermissions[] = trim(htmlspecialchars($permission));
                }
            }
        }

        $newUser = User::create([
            'first_name' => trim(htmlspecialchars($request['firstName'])),
            'last_name' => trim(htmlspecialchars($request['lastName'])),
            'country_code' => trim(htmlspecialchars($request['countryCode'])),
            'phone_number' => trim(htmlspecialchars($request['phoneNumber'])),
            'email' => trim(htmlspecialchars($request['email'])),
            'password' => Hash::make(env('NEW_USER_PASSWORD', '')),
            'address' => trim(htmlspecialchars($request['address'])),
            'city' => trim(htmlspecialchars($request['city'])),
            'state' => trim(htmlspecialchars($request['state'])),
            'country' => trim(htmlspecialchars($request['country'])),
            'postal_code' => trim(htmlspecialchars($request['postalCode'])),
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

    public function getAllEmployees()
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        if ($user->isAbleTo(PermissionConst::VIEW_EMPLOYEE, $user->company->name)) {

            $userObj = User::join('role_user', 'role_user.user_id', '=', 'users.id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('users.company_id', $user->company->id)
                ->where('users.status', '!=', 'D');

            if (!$user->hasRole('superAdmin', $user->company->name)) {
                $userObj->where('roles.name', '!=', 'superAdmin');
            }

            $employees = $userObj->get();

            foreach ($employees as $key => $employee) {
                $employees[$key]['roles'] = $employee->roles;
            }

            return $employees;
        }
    }

    public function getEmployee(Request $request, $employeeId) 
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        $validationRule = [
            'permission' => ['required', 'string', new CheckPermissions($user)] 
        ];
        
        Validator::make(['permission' => PermissionConst::UPDATE_EMPLOYEE], $validationRule)->validate();
        
        $user = User::where('id', trim(htmlspecialchars($employeeId)))
            ->where('company_id', $user->company->id)
            ->first();

        $user['permissions'] = $user->allPermissions();
        $user['roles'] = $user->roles;
        
        return $user;
    }

    public function updateEmployee(Request $request)
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        $validationRule = [
            'permission' => ['required', 'string', new CheckPermissions($user)] 
        ];
        
        Validator::make(['permission' => PermissionConst::UPDATE_EMPLOYEE], $validationRule)->validate();

        $rules = [
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'countryCode' => ['required', 'digits_between:1,3'],
            'phoneNumber' => ['required', 'digits_between:5,12'],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email,{$request->employeeId}"],
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

        $role = Role::where('name', trim(htmlspecialchars($request->role)))->first();
        $rolePermissions = (array) $role->permissions;
        
        $additionalPermissions = [];

        foreach ($rolePermissions as $rolePermission) {
            foreach ($request->permissions as $permission) {
                if (!in_array($permission, array_column($rolePermission, 'name'))) {
                    $additionalPermissions[] = trim(htmlspecialchars($permission));
                }
            }
        }

        User::where('id', trim(htmlspecialchars($request->employeeId)))
            ->where('company_id', $user->company->id)
            ->update([
                'first_name' => trim(htmlspecialchars($request->firstName)),
                'last_name' => trim(htmlspecialchars($request->lastName)),
                'country_code' => trim(htmlspecialchars($request->countryCode)),
                'phone_number' => trim(htmlspecialchars($request->phoneNumber)),
                'email' => trim(htmlspecialchars($request->email)),
                'address' => trim(htmlspecialchars($request->address)),
                'city' => trim(htmlspecialchars($request->city)),
                'state' => trim(htmlspecialchars($request->state)),
                'country' => trim(htmlspecialchars($request->country)),
                'postal_code' => trim(htmlspecialchars($request->postalCode)),
            ]);
        
        $employee = User::findOrFail($request->employeeId);
        $employeeRoles = $employee->roles;
        
        if ($employeeRoles[0]->id != $role->id) {
            $employee->attachRole($role, $user->company);
            $employee->detachRoles($employeeRoles, $user->company);
        }

        $employee->detachPermissions($employee->allPermissions(), $user->company);

        if (!empty($additionalPermissions)) {

            foreach ($additionalPermissions as $permission) {

                if ($objPermission = Permission::where('name', $permission)->first()) {
                    $employee->attachPermission($objPermission, $user->company);
                }
            }

        }

        return $employee;
    }
}
