<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UnitTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unit_type')->insert([
            'unit_type_name' => 'Pcs'
        ]);
        DB::table('unit_type')->insert([
            'unit_type_name' => 'Kg'
        ]);
        DB::table('unit_type')->insert([
            'unit_type_name' => 'Box'
        ]);
        DB::table('unit_type')->insert([
            'unit_type_name' => 'Gram'
        ]);
        DB::table('unit_type')->insert([
            'unit_type_name' => 'cm'
        ]);
        DB::table('unit_type')->insert([
            'unit_type_name' => 'm'
        ]);
        DB::table('unit_type')->insert([
            'unit_type_name' => 'inches'
        ]);
    }
}
