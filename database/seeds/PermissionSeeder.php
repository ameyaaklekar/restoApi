<?php

use App\Model\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'addEmployee',
                'display_name' => 'Add Employee'
            ],
            [
                'name' => 'updateEmployee',
                'display_name' => 'Update Employee'
            ],
            [
                'name' => 'deleteEmployee',
                'display_name' => 'Delete Employee'
            ],
            [
                'name' => 'viewEmployee',
                'display_name' => 'View Employee'
            ],
            [
                'name' => 'addBranch',
                'display_name' => 'Add Branch'
            ],
            [
                'name' => 'updateBranch',
                'display_name' => 'Update Branch'
            ],
            [
                'name' => 'deleteBranch',
                'display_name' => 'Delete Branch'
            ],
            [
                'name' => 'viewBranch',
                'display_name' => 'View Branch'
            ],
            [
                'name' => 'givePermissions',
                'display_name' => 'Give Permissions'
            ],
            [
                'name' => 'removePermissions',
                'display_name' => 'Delete Permissions'
            ],
            [
                'name' => 'viewPermissions',
                'display_name' => 'View Permissions'
            ],
            [
                'name' => 'addRoles',
                'display_name' => 'Add Roles'
            ],
            [
                'name' => 'updateRoles',
                'display_name' => 'Update Roles'
            ],
            [
                'name' => 'deleteRoles',
                'display_name' => 'Delete Roles'
            ],
            [
                'name' => 'viewRoles',
                'display_name' => 'View Roles'
            ],
            [
                'name' => 'viewCompany',
                'display_name' => 'View Company'
            ],
            [
                'name' => 'updateCompany',
                'display_name' => 'Edit Company'
            ],
            [
                'name' => 'deleteCompany',
                'display_name' => 'Delete Company'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'display_name' => $permission['display_name']
            ]);
        }
    }
}
