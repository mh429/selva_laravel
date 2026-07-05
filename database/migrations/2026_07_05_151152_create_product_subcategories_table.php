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
        Schema::create('product_subcategories', function (Blueprint $table) {
            $table->id()->comment('サブカテゴリID');
            $table->foreignId('product_category_id')->comment('カテゴリID');
            $table->string('name')->comment('サブカテゴリ名');
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
        Schema::dropIfExists('product_subcategories');
    }
};
