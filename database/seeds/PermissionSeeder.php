<?php

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
                'name' => 'editEmployee',
                'display_name' => 'Edit Employee'
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
                'name' => 'editBranch',
                'display_name' => 'Edit Branch'
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
                'name' => 'exportTimesheet',
                'display_name' => 'Export Timesheet'
            ],
            [
                'name' => 'addPermissions',
                'display_name' => 'Add Permissions'
            ],
            [
                'name' => 'editPermissions',
                'display_name' => 'Edit Permissions'
            ],
            [
                'name' => 'updatePermissions',
                'display_name' => 'Update Permissions'
            ],
            [
                'name' => 'deletePermissions',
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
                'name' => 'editRoles',
                'display_name' => 'Edit Roles'
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
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert(
                [
                    'name' => $permission['name'],
                    'display_name' => $permission['display_name'],
                    'created_at' => NOW(),
                    'updated_at' => NOW()
                ]
            );
        }
    }
}
