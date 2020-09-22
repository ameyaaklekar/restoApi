<?php
namespace Database\Seeders;

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
        $this->call(PermissionSeeder::class);
        $this->command->info('permission table seeded!');
        $this->call(RoleSeeder::class);
        $this->command->info('roles table seeded!');
        $this->call(RolesPermission::class);
        $this->command->info('roles_permission table seeded!');
        $this->call(UserSeeder::class);
        $this->command->info('user table seeded!');
        $this->call(GeneralUnitSeeder::class);
        $this->command->info('general_unit table seeded!');
        $this->call(WeightTypeSeeder::class);
        $this->command->info('weight_type table seeded!');
    }
}
