<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('product_categories')->insert([
        //     [
        //         'id' => 1,
        //         'name' => 'インテリア',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //         'deleted_at' => null,
        //     ],
        //     [
        //         'id' => 2,
        //         'name' => '家電',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //         'deleted_at' => null,
        //     ],
        //     [
        //         'id' => 3,
        //         'name' => 'ファッション',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //         'deleted_at' => null,
        //     ],
        //     [
        //         'id' => 4,
        //         'name' => '美容',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //         'deleted_at' => null,
        //     ],
        //     [
        //         'id' => 5,
        //         'name' => '本・雑誌',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //         'deleted_at' => null,
        //     ],
        // ]);

        for ($i = 6; $i <= 40; $i++) {
            DB::table('product_categories')->insert([
                'id' => $i,
                'name' => 'カテゴリ' . ($i),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]);
        }
    }
}
