<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = ['amount' => 3000];
        DB::table('courses')->insert($param);

        $param = ['amount' => 5000];
        DB::table('courses')->insert($param);

    }
}
