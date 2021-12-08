<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transaction_type')->insert([
            'transaction_type_name' => 'Buy'
        ]);
        DB::table('transaction_type')->insert([
            'transaction_type_name' => 'Sell'
        ]);
    }
}
