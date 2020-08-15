<?php

namespace App\Rules;

use App\Model\Company\Company;
use Illuminate\Contracts\Validation\Rule;

class UniqueSupplierName implements Rule
{
    protected $companyId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($companyId)
    {
        $this->companyId = $companyId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $company = Company::find($this->companyId);

        if ($company) {
            $supplierExist = $company->suppliers()->where('name', $value)->count();

            if (!$supplierExist) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Supplier already exist.';
    }
}
