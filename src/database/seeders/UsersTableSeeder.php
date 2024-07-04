<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'role_id' => '2',
            'name' => 'ウエオカジュン',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password')
        ];
        DB::table('users')->insert($param);
    }
}
