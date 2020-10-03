<?php

namespace App\Http\Controllers\Company;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Constants\PermissionConstants;

class CompanyController extends Controller
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

    public function getEmployees()
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        if ($user->isAbleTo(PermissionConstants::VIEW_EMPLOYEE, $user->company->name)) {

            $userObj = User::join('role_user', 'role_user.user_id', '=', 'users.id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('users.company_id', $user->company->id)
                ->where('users.status', '!=', 'D')
                ->select('users.*');
            
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
}
