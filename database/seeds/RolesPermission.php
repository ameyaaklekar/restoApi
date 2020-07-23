<?php

use App\Model\Role;
use App\Model\Permission;
use Illuminate\Database\Seeder;

class RolesPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $adminPermissions = [
            'addEmployee',
            'updateEmployee',
            'deleteEmployee',
            'viewEmployee',
            'addBranch',
            'updateBranch',
            'deleteBranch',
            'viewBranch',
            'givePermissions',
            'removePermissions',
            'viewPermissions',
            'addRoles',
            'updateRoles',
            'deleteRoles',
            'viewRoles',
            'viewCompany',
            'updateCompany',
            'deleteCompany',
            'updateProfile'
        ];

        
        $admin = Role::where('name', 'admin')->first();

        foreach ($adminPermissions as $permission) {
            $admin->attachPermission(Permission::where('name', $permission)->first());
        }

        $managerPermissions = [
            'addEmployee',
            'updateEmployee',
            'deleteEmployee',
            'viewEmployee',
            'viewBranch',
            'givePermissions',
            'removePermissions',
            'viewPermissions',
            'viewRoles',
            'viewCompany',
            'updateProfile'
        ];
        
        $manager = Role::where('name', 'manager')->first();
        foreach ($managerPermissions as $permission) {
            $manager->attachPermission(Permission::where('name', $permission)->first());
        }

        $supervisor = Role::where('name', 'supervisor')->first();
        $employee = Role::where('name', 'employee')->first();
    }
}
