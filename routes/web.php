<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MypageController;


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

    // 画像用アップロード用のルート（Ajax）
    Route::post('/product/upload', [ProductController::class, 'upload']);

    Route::post('product/confirm', [ProductController::class, 'confirm'])
    ->name('product.confirm');

    Route::post('product/store', [ProductController::class, 'store'])
    ->name('product.store');

});

Route::get('product', [ProductController::class, 'index'])
->name('product.index');

Route::get('product/show/{product}', [ProductController::class, 'show'])
->name('product.show');

Route::get('product/showreviews/{product}', [ProductController::class, 'showReviews'])
->name('product.showreviews');

// サブカテゴリ表示用のルート（Ajax）
Route::get('/product/subcategories/{category}',[ProductController::class, 'getSubcategories']);


/**
 * レビュー登録
 */

Route::middleware('auth')->group(function () {

    Route::get('review/create/{product}', [ReviewController::class, 'create'])
    ->name('review.create');

    Route::post('review/confirm/{product}', [ReviewController::class, 'confirm'])
    ->name('review.confirm');

    Route::post('review/store/{product}', [ReviewController::class, 'store'])
    ->name('review.store');

});


/**
 * マイページ機能
 */

Route::middleware('auth')->group(function () {

    Route::get('mypage', [MypageController::class, 'mypage'])
    ->name('mypage');

    /**
     * 退会
     */
    Route::get('mypage/withdrawal', [MypageController::class, 'withdrawalConfirm'])
    ->name('mypage.withdrawalconfirm');

    Route::post('mypage/withdrawal', [MypageController::class, 'withdrawal'])
    ->name('mypage.withdrawal');

    /**
     * 会員情報変更
     */
    Route::get('mypage/edit', [MypageController::class, 'edit'])
    ->name('mypage.edit');

    Route::post('mypage/edit', [MypageController::class, 'editConfirm'])
    ->name('mypage.edit.confirm');

    Route::patch('mypage/edit', [MypageController::class, 'update'])
    ->name('mypage.update');

    /**
     * パスワード変更
     */
    Route::get('mypage/editpassword', [MypageController::class, 'editPassword'])
    ->name('mypage.editpassword');

    Route::patch('mypage/editpassword', [MypageController::class, 'updatePassword'])
    ->name('mypage.updatepassword');

    /**
     * メールアドレス変更
     */
    Route::get('mypage/editemail', [MypageController::class, 'editEmail'])
    ->name('mypage.editemail');

    Route::post('mypage/editemailsendcode', [MypageController::class, 'editEmailSendcode'])
    ->name('mypage.editemail.sendcode');

    Route::patch('mypage/updateemail', [MypageController::class, 'updateEmail'])
    ->name('mypage.updateemail');

    /**
     * レビュー管理
     */
    Route::get('mypage/review', [MypageController::class, 'review'])
    ->name('mypage.review');

    // 編集
    Route::get('mypage/review/{review}/edit', [MypageController::class, 'reviewEdit'])
    ->name('mypage.review.edit');

    Route::post('mypage/review/{review}/edit/confirm', [MypageController::class, 'reviewEditConfirm'])
    ->name('mypage.review.edit.confirm');

    Route::patch('mypage/review/{review}/update', [MypageController::class, 'reviewUpdate'])
    ->name('mypage.review.update');

    // 削除
    Route::get('mypage/review/{review}/delete/confirm', [MypageController::class, 'reviewDeleteConfirm'])
    ->name('mypage.review.delete.confirm');

    Route::delete('mypage/review/{review}/delete', [MypageController::class, 'reviewDelete'])
    ->name('mypage.review.delete');
});
