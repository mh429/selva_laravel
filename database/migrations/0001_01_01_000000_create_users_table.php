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
        Schema::create('members', function (Blueprint $table) {
            $table->id()->comment('会員ID');
            $table->string('name_sei')->comment('氏名（姓）');
            $table->string('name_mei')->comment('氏名（名）');
            $table->string('nickname')->comment('ニックネーム');
            $table->integer('gender')->comment('性別（1=男性、2=女性）');
            $table->string('password')->comment('パスワード');
            $table->string('email')->unique()->comment('メールアドレス');
            $table->integer('auth_code')->nullable()->default(null)->comment('認証コード');
            $table->timestamp('created_at')->nullable()->default(null)->comment('登録日時');
            $table->timestamp('updated_at')->nullable()->default(null)->comment('編集日時');
            $table->timestamp('deleted_at')->nullable()->default(null)->comment('削除日時');
        });

        // Schema::create('users', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('email')->unique();
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->string('password');
        //     $table->rememberToken();
        //     $table->timestamps();
        // });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
