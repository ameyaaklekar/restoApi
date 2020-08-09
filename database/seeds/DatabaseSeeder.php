<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call('PermissionSeeder');
        $this->command->info('permission table seeded!');
        $this->call('RoleSeeder');
        $this->command->info('roles table seeded!');
        $this->call('RolesPermission');
        $this->command->info('roles_permission table seeded!');
        $this->call('UserSeeder');
        $this->command->info('user table seeded!');
        $this->call('WeightTypeSeeder');
        $this->command->info('weight_type table seeded!');
        $this->call('GeneralUnitSeeder');
        $this->command->info('general_unit table seeded!');
    }
}
