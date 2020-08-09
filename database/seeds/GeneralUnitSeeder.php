<?php

use Illuminate\Database\Seeder;

class GeneralUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = [
            'kgs - Kilo Gram',
            'gms - Grams',
            'mgs - Milli Grams',
            'l - Liter',
            'ml - Milli Liter',
            'count - Piece'
        ];

        foreach ($units as $unit) {
            DB::table('general_units')->insert([
                'description' => $unit,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]);
        }
    }
}
