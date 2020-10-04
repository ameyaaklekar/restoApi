<?php

namespace App\Http\Controllers\Suppliers;

use App\Model\User;
use Illuminate\Http\Request;
use App\Model\Suppliers\Suppliers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Constants\PermissionConstants;
use App\Model\Permission;
use App\Rules\CheckPermissions;
use App\Rules\UniqueSupplierName;
use Exception;

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

    public function getAllSupplier(Request $request, Suppliers $supplier) 
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        try {
            $this->authorize('view', $supplier);
    
            $suppliers = Suppliers::where('company_id', $user->company->id)
                ->where('status', '!=', 'D')
                ->get();

            return $this->response(true, 200, $suppliers);
        } catch (Exception $e) {
            return $this->response(false, ($e->getCode()) ? $e->getCode() : 403, [], $e->getMessage());
        }
    }

    public function addSupplier(Request $request, Suppliers $supplier) 
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        try {

            $this->authorize('create', $supplier);

            $rules = [
                'name' => ['required', 'string', 'max:255', new UniqueSupplierName($user->company->id)],
                'countryCode' => ['required', 'digits_between:1,3'],
                'contact' => ['required', 'digits_between:5,12'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'contactPerson' => ['required', 'string', 'max:255'],
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

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return $this->response(false, 422, $validator->errors(), 'Please enter valid details');
            }

            $supplier = Suppliers::create([
                'name' => trim(htmlspecialchars($request->name)),
                'country_code' => trim(htmlspecialchars($request->countryCode)),
                'contact' => trim(htmlspecialchars($request->contact)),
                'email' => trim(htmlspecialchars($request->email)),
                'contact_person' => trim(htmlspecialchars($request->contactPerson)),
                'address' => trim(htmlspecialchars($request->address)),
                'city' => trim(htmlspecialchars($request->city)),
                'state' => trim(htmlspecialchars($request->state)),
                'country' => trim(htmlspecialchars($request->country)),
                'postal_code' => trim(htmlspecialchars($request->postalCode)),
                'company_id' => trim(htmlspecialchars($user->company->id))
            ]);

            return $this->response(true, 200, $supplier, 'Supplier added successfully');
        } catch (Exception $e) {
            return $this->response(false, ($e->getCode()) ? $e->getCode() : 403, [], $e->getMessage());
        }
    }

    public function changeStatus(Request $request, Suppliers $supplier) 
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        try {
            $this->authorize('update', $supplier);

            $rules = [
                'companyId' => ['required', 'integer', 'exists:company,id'],
                'supplierId' => ['required', 'integer', 'exists:suppliers,id'],
                'status' => ['required', 'string', 'max:1']
            ];
    
            $messages = [
                'required' => 'The :attribute is required.',
                'max' => 'Invalid Status'
            ];
    
            Validator::make($request->all(), $rules, $messages)->validate();
            
            $updated = Suppliers::where('id', trim(htmlspecialchars($request->supplierId)))
                ->where('company_id', $user->company->id)
                ->update(['status' => ($request->status == 'A') ? 'A' : 'I']);

            if ($updated) {
                return $this->response(true, 200, null, 'Status Changed Successfully');
            }

            
        } catch (Exception $e) {
            return $this->response(false, ($e->getCode()) ? $e->getCode() : 403, [], $e->getMessage());
        }
    }

    public function getSupplier(Request $request, Suppliers $supplier, $supplierId) 
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        try {
            $this->authorize('update', $supplier);

            $supplier = Suppliers::where('id', trim(htmlspecialchars($supplierId)))
                ->where('company_id', $user->company->id)
                ->first();

            return $this->response(true, 200, $supplier, null);
        } catch (Exception $e) {
            return $this->response(false, ($e->getCode()) ? $e->getCode() : 403, [], $e->getMessage());
        }
    }

    public function updateSupplier(Request $request, Suppliers $supplier) 
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);
        
        try {
            $this->authorize('update', $supplier);

            $rules = [
                'countryCode' => ['required', 'digits_between:1,3'],
                'contact' => ['required', 'digits_between:5,12'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'contactPerson' => ['required', 'string', 'max:255'],
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
    
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return $this->response(false, 422, $validator->errors(), 'Please enter valid details');
            }

            $supplier = Suppliers::where('id', trim(htmlspecialchars($request->supplierId)))
                ->where('company_id', $user->company->id)
                ->update([
                    'country_code' => trim(htmlspecialchars($request->countryCode)),
                    'contact' => trim(htmlspecialchars($request->contact)),
                    'email' => trim(htmlspecialchars($request->email)),
                    'contact_person' => trim(htmlspecialchars($request->contactPerson)),
                    'address' => trim(htmlspecialchars($request->address)),
                    'city' => trim(htmlspecialchars($request->city)),
                    'state' => trim(htmlspecialchars($request->state)),
                    'country' => trim(htmlspecialchars($request->country)),
                    'postal_code' => trim(htmlspecialchars($request->postalCode)),
                ]);
    
            return $this->response(true, 200, $supplier, 'Supplier updated successfully');
        } catch (Exception $e) {
            return $this->response(false, ($e->getCode()) ? $e->getCode() : 403, [], $e->getMessage());
        }
    }
}
