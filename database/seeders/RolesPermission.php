<?php
namespace Database\Seeders;

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
            'updateProfile',
            'addStock',
            'viewStock',
            'updateStock',
            'deleteStock',
            'addSupplier',
            'viewSupplier',
            'updateSupplier',
            'deleteSupplier',
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
            'updateProfile',
            'viewStock',
            'viewSupplier',
        ];
        
        $manager = Role::where('name', 'manager')->first();
        foreach ($managerPermissions as $permission) {
            $manager->attachPermission(Permission::where('name', $permission)->first());
        }

        $supervisorPermissions = [
            'viewEmployee',
            'givePermissions',
            'removePermissions',
            'viewPermissions',
            'viewRoles',
            'viewCompany',
            'updateProfile'
        ];
        $supervisor = Role::where('name', 'supervisor')->first();
        foreach ($supervisorPermissions as $permission) {
            $supervisor->attachPermission(Permission::where('name', $permission)->first());
        }

        $employeePermissions = [
            'viewCompany'
        ];
        $employee = Role::where('name', 'employee')->first();
        foreach ($employeePermissions as $permission) {
            $employee->attachPermission(Permission::where('name', $permission)->first());
        }
    }
}
