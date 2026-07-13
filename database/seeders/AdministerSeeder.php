<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdministerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('administers')->insert([
            [
                'name' => '管理太郎',
                'login_id' => 'kanritarou',
                'password' => bcrypt('admin0001'),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'name' => '管理次郎',
                'login_id' => 'kanrijirou',
                'password' => bcrypt('admin0002'),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
