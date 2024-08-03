<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

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
            'name' => '上岡 純',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password')
        ];
        DB::table('users')->insert($param);

        // User::factory(100)->create();
    }
}
