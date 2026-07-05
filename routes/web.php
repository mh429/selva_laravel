<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;


/**
 * トップ画面
 */

Route::get('/', function () {
    return view('top');
})->name('top');


/**
 * 会員登録
 */

Route::get('member/create', [MemberController::class, 'create'])
->name('member.create');

Route::post('member/confirm', [MemberController::class, 'confirm'])
->name('member.confirm');

Route::post('member/store', [MemberController::class, 'store'])
->name('member.store');


/**
 * ログイン関連
 */

Route::get('login', [LoginController::class, 'showLoginForm'])
->name('login');

Route::post('login', [LoginController::class, 'login']);

Route::post('logout', [LoginController::class, 'logout'])
->name('logout');

Route::get('passwordResetMail', [LoginController::class, 'showPasswordResetMailForm'])
->name('showPasswordResetMailForm');

Route::post('passwordResetMail', [LoginController::class, 'sendPasswordResetMail'])
->name('sendPasswordResetMail');

Route::get('/password-reset/{token}', [LoginController::class, 'showPasswordResetForm'])
->name('passwordReset');

Route::post('/password-reset/{token}', [LoginController::class, 'passwordReset']);


/**
 * 商品登録
 */

Route::middleware('auth')->group(function () {

    Route::get('product/create', [ProductController::class, 'create'])
    ->name('product.create');
    // サブカテゴリと画像用のルート（Ajax）
    Route::get('/product/subcategories/{category}',[ProductController::class, 'getSubcategories']);
    Route::post('/product/upload', [ProductController::class, 'upload']);

    Route::post('product/confirm', [ProductController::class, 'confirm'])
    ->name('product.confirm');

    Route::post('product/store', [ProductController::class, 'store'])
    ->name('product.store');

});