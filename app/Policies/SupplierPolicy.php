<?php

namespace App\Policies;

use App\Constants\PermissionConstants;
use App\Model\User;
use App\Model\Suppliers\Suppliers;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class SupplierPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Suppliers\Suppliers  $suppliers
     * @return mixed
     */
    public function view(User $user, Suppliers $suppliers)
    {
        return ($user->isAbleTo(PermissionConstants::VIEW_SUPPLIER, $user->company->name)) ?
            Response::allow() : Response::deny($this->denyResponse);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Model\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return ($user->isAbleTo(PermissionConstants::ADD_SUPPLIER, $user->company->name)) ?
            Response::allow() : Response::deny($this->denyResponse);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Suppliers\Suppliers  $suppliers
     * @return mixed
     */
    public function update(User $user, Suppliers $suppliers)
    {
        return ($user->isAbleTo(PermissionConstants::UPDATE_SUPPLIER, $user->company->name)) ?
            Response::allow() : Response::deny($this->denyResponse);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Suppliers\Suppliers  $suppliers
     * @return mixed
     */
    public function delete(User $user, Suppliers $suppliers)
    {
        return ($user->isAbleTo(PermissionConstants::DELETE_SUPPLIER, $user->company->name)) ?
            Response::allow() : Response::deny($this->denyResponse);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Suppliers\Suppliers  $suppliers
     * @return mixed
     */
    public function restore(User $user, Suppliers $suppliers)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Suppliers\Suppliers  $suppliers
     * @return mixed
     */
    public function forceDelete(User $user, Suppliers $suppliers)
    {
        //
    }
}
