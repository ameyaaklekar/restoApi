<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeightTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Weight (1 Kilo)',
            'Volume (1 Liter)',
            'Count (1 Unit)'
        ];


        foreach ($types as $type) {
            DB::table('weight_type')->insert([
                'name' => $type,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]);
        }
    }
}
