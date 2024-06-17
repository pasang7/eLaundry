<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'SuperAdmin',
                'email' => 'superadmin@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now()
               ],
               [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now()
               ],
               [
                'name' => 'Accounts',
                'email' => 'account@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now()
               ],
               [
                'name' => 'Staff',
                'email' => 'staff@gmail.com',
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now()
               ]
        ];
        DB::table('users')->insert($users);
    }
}
