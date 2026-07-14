<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('product_subcategories')->insert([
        //     ['id' => 1,  'product_category_id' => 1, 'name' => '収納家具',     'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 2,  'product_category_id' => 1, 'name' => '寝具',         'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 3,  'product_category_id' => 1, 'name' => 'ソファ',       'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 4,  'product_category_id' => 1, 'name' => 'ベッド',       'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 5,  'product_category_id' => 1, 'name' => '照明',         'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],

        //     ['id' => 6,  'product_category_id' => 2, 'name' => 'テレビ',       'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 7,  'product_category_id' => 2, 'name' => '掃除機',       'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 8,  'product_category_id' => 2, 'name' => 'エアコン',     'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 9,  'product_category_id' => 2, 'name' => '冷蔵庫',       'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 10, 'product_category_id' => 2, 'name' => 'レンジ',       'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],

        //     ['id' => 11, 'product_category_id' => 3, 'name' => 'トップス',     'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 12, 'product_category_id' => 3, 'name' => 'ボトム',       'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 13, 'product_category_id' => 3, 'name' => 'ワンピース',   'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 14, 'product_category_id' => 3, 'name' => 'ファッション小物', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 15, 'product_category_id' => 3, 'name' => 'ドレス',       'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],

        //     ['id' => 16, 'product_category_id' => 4, 'name' => 'ネイル',       'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 17, 'product_category_id' => 4, 'name' => 'アロマ',       'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 18, 'product_category_id' => 4, 'name' => 'スキンケア',   'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 19, 'product_category_id' => 4, 'name' => '香水',         'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 20, 'product_category_id' => 4, 'name' => 'メイク',       'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],

        //     ['id' => 21, 'product_category_id' => 5, 'name' => '旅行',         'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 22, 'product_category_id' => 5, 'name' => 'ホビー',       'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 23, 'product_category_id' => 5, 'name' => '写真集',       'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 24, 'product_category_id' => 5, 'name' => '小説',         'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        //     ['id' => 25, 'product_category_id' => 5, 'name' => 'ライフスタイル', 'created_at' => now(), 'updated_at' => now(), 'deleted_at' => null],
        // ]);

        $id = 26;
        for ($categoryId = 6; $categoryId <= 40; $categoryId++) {
            for ($i = 1; $i <= 2; $i++) {
                DB::table('product_subcategories')->insert([
                    'id' => $id++,
                    'product_category_id' => $categoryId,
                    'name' => 'サブカテゴリ' . ($categoryId) . '-' . $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ]);
            }
        }
    }
}
