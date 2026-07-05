<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id()->comment('商品ID');
            $table->foreignId('member_id')->comment('会員ID');
            $table->foreignId('product_category_id')->comment('カテゴリID');
            $table->foreignId('product_subcategory_id')->comment('サブカテゴリID');
            $table->string('name')->comment('商品名');
            $table->string('image_1')->nullable()->comment('写真1');
            $table->string('image_2')->nullable()->comment('写真2');
            $table->string('image_3')->nullable()->comment('写真3');
            $table->string('image_4')->nullable()->comment('写真4');
            $table->text('product_content')->comment('商品説明');
            $table->timestamp('created_at')->nullable()->default(null)->comment('登録日時');
            $table->timestamp('updated_at')->nullable()->default(null)->comment('編集日時');
            $table->timestamp('deleted_at')->nullable()->default(null)->comment('削除日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
