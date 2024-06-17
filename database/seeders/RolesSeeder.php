<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Roles
        $roles = [
            [
                'role_name' => 'superadmin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'role_name' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'role_name' => 'account',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'role_name' => 'staff',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        DB::table('roles')->insert($roles);

    }
}
