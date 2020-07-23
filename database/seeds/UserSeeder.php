<?php

use App\Model\Role;
use App\Model\User;
use App\Model\Permission;
use App\Model\Company\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companyId = DB::table('company')->insert([
            'name' => 'Cultural Switch',
            'display_name' => 'Cultural Switch',
            'created_at' => NOW(),
            'updated_at' => NOW()
        ]);

        $userId = DB::table('users')->insert(
            [
                'first_name' => 'Ameya',
                'last_name' => 'Aklekar',
                'country_code' => '64',
                'phone_number' => '0224116255',
                'email' => 'ameyaaklekar@gmail.com',
                'password' => Hash::make('Ameya1993'),
                'company_id' => $companyId,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        );

        $user = User::where('id', 1)->get()->first();
        $company = Company::where('id', 1)->get()->first();

        $superAdmin = Role::where('name', 'superAdmin')->first();

        $allPermissions = Permission::all();

        foreach ($allPermissions as $permission) {
            $superAdmin->attachPermission($permission);
        }

        $user->attachRole($superAdmin, $company);
    }
}
