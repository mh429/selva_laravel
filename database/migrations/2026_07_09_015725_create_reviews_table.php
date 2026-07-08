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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id()->comment('商品ID');
            $table->foreignId('member_id')->comment('会員ID');
            $table->foreignId('product_id')->comment('商品ID');
            $table->integer('evaluation')->comment('評価');
            $table->text('comment')->comment('商品コメント');
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
        Schema::dropIfExists('reviews');
    }
};
