<?php

namespace App\Providers;

use App\Constants\PermissionConstants;
use App\Model\Suppliers\Suppliers;
use App\Policies\SupplierPolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Suppliers::class => SupplierPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define(PermissionConstants::VIEW_SUPPLIER, function ($user) {
            return $user->isAbleTo(PermissionConstants::VIEW_SUPPLIER, $user->company->name) ? 
                Response::allow() : Response::deny('User not authorized for this action');
        });
    }
}
