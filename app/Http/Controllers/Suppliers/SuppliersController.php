<?php

namespace App\Http\Controllers\Suppliers;

use App\Model\User;
use Illuminate\Http\Request;
use App\Model\Suppliers\Suppliers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Constants\Permission as PermissionConst;
use App\Rules\UniqueSupplierName;
use Exception;
use Throwable;

class SuppliersController extends Controller
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

    public function allSupplier(Request $request) 
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        if ($user->isAbleTo(PermissionConst::VIEW_SUPPLIER, $user->company->name)) {
            $companyId = $request->company;

            return Suppliers::where('company_id', $companyId)
                ->where('status', '!=', 'D')
                ->get();
        }
    }

    public function addSupplier(Request $request) 
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        if ($user->isAbleTo(PermissionConst::ADD_SUPPLIER, $user->company->name)) { 
            $rules = [
                'name' => ['required', 'string', 'max:255', new UniqueSupplierName($user->company->id)],
                'countryCode' => ['required', 'digits_between:1,3'],
                'contact' => ['required', 'digits_between:5,12'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'address' => ['string', 'max:255'],
                'city' => ['string', 'max:255'],
                'state' => ['string', 'max:255'],
                'country' => ['string', 'max:255'],
                'postalCode' => ['string', 'max:255']
            ];

            $messages = [
                'required' => 'The :attribute is required.',
                'max' => 'The :attribute is too long.'
            ];

            Validator::make($request->all(), $rules, $messages)->validate();

            Suppliers::create([
                'name' => trim(htmlspecialchars($request->name)),
                'country_code' => trim(htmlspecialchars($request->countryCode)),
                'contact' => trim(htmlspecialchars($request->contact)),
                'email' => trim(htmlspecialchars($request->email)),
                'address' => trim(htmlspecialchars($request->address)),
                'city' => trim(htmlspecialchars($request->city)),
                'state' => trim(htmlspecialchars($request->state)),
                'country' => trim(htmlspecialchars($request->country)),
                'postal_code' => trim(htmlspecialchars($request->postalCode)),
                'company_id' => trim(htmlspecialchars($user->company->id))
            ]);
        } else {
            // throw new Exception('User not Authorized to perform this action');
        }
    }
}
