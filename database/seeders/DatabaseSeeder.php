<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'name' => 'E-Laundry',
            'logo' => '1.png',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('receipt_numbers')->insert([
            'receipt_number' => '0',
        ]);
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(RoleUserSeeder::class);
        $this->call(LedgersSeeder::class);

    }
}
