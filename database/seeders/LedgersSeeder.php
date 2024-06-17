<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LedgersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ledgers = [
            [
                'name' => 'cash',
                'opening_balance' => '0',
                'created_at' => now(),
                'updated_at' => now()
               ],
               [
                   'name' => 'bank',
                   'opening_balance' => '0',
                   'created_at' => now(),
                   'updated_at' => now()
               ],
               [
                   'name' => 'debtors',
                   'opening_balance' => '0',
                   'created_at' => now(),
                   'updated_at' => now()
                  ],
                  [
                   'name' => 'expense',
                   'opening_balance' => '0',
                   'created_at' => now(),
                   'updated_at' => now()
                  ],
        ];
        DB::table('ledgers')->insert($ledgers);

    }
}
