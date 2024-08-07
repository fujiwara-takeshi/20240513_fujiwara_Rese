<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = ['name' => '利用者'];
        DB::table('roles')->insert($param);

        $param = ['name' => '管理者'];
        DB::table('roles')->insert($param);

        $param = ['name' => '店舗代表者'];
        DB::table('roles')->insert($param);
    }
}
