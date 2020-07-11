<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'superAdmin',
                'display_name' => 'Super Admin'
            ],
            [
                'name' => 'admin',
                'display_name' => 'Admin'
            ],
            [
                'name' => 'manager',
                'display_name' => 'Manager'
            ],
            [
                'name' => 'supervisor',
                'display_name' => 'Supervisor'
            ],
            [
                'name' => 'employee',
                'display_name' => 'Employee'
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert(
                [
                    'name' => $role['name'],
                    'display_name' => $role['display_name'],
                    'created_at' => NOW(),
                    'updated_at' => NOW()
                ]
            );
        }
    }
}
