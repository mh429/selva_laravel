<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminMemberController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminReviewController;

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
    Route::post('/product/upload', [ProductController::class, 'upload'])
    ->name('product.upload');

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

    Route::get('mypage/editemail/inputcode', [MypageController::class, 'showEditEmailInputCode'])
    ->name('mypage.editemail.inputcode');

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



/**
 * 管理者ログイン関連
 */

Route::get('admin/login', [AdminLoginController::class, 'showLoginForm'])
->name('admin.login');

Route::post('admin/login', [AdminLoginController::class, 'login']);


Route::middleware('auth:admin')->group(function () {

    Route::post('admin/logout', [AdminLoginController::class, 'logout'])
    ->name('admin.logout');

    Route::get('admin/index', [AdminLoginController::class, 'index'])
    ->name('admin.index');

});


/**
 * 管理者　会員管理
 */

Route::middleware('auth:admin')->group(function () {

    Route::get('admin/member/index', [AdminMemberController::class, 'index'])
    ->name('admin.member.index');

    Route::get('admin/member/create', [AdminMemberController::class, 'create'])
    ->name('admin.member.create');

    Route::post('admin/member/create/confirm', [AdminMemberController::class, 'createConfirm'])
    ->name('admin.member.create.confirm');

    Route::post('admin/member/store', [AdminMemberController::class, 'store'])
    ->name('admin.member.store');

    Route::get('admin/member/show/{user}', [AdminMemberController::class, 'show'])
    ->name('admin.member.show');

    Route::get('admin/member/{user}/edit', [AdminMemberController::class, 'edit'])
    ->name('admin.member.edit');

    Route::post('admin/member/{user}/edit/confirm', [AdminMemberController::class, 'editConfirm'])
    ->name('admin.member.edit.confirm');

    Route::patch('admin/member/{user}', [AdminMemberController::class, 'update'])
    ->name('admin.member.update');

    Route::delete('admin/member/{user}', [AdminMemberController::class, 'destroy'])
    ->name('admin.member.destroy');

});


/**
 * 管理者　カテゴリ管理
 */

Route::middleware('auth:admin')->group(function () {

    Route::get('admin/category/index', [AdminCategoryController::class, 'index'])
    ->name('admin.category.index');

    Route::get('admin/category/create', [AdminCategoryController::class, 'create'])
    ->name('admin.category.create');

    Route::post('admin/category/create/confirm', [AdminCategoryController::class, 'createConfirm'])
    ->name('admin.category.create.confirm');

    Route::post('admin/category/store', [AdminCategoryController::class, 'store'])
    ->name('admin.category.store');

    Route::get('admin/category/show/{productCategory}', [AdminCategoryController::class, 'show'])
    ->name('admin.category.show');

    Route::get('admin/category/{productCategory}/edit', [AdminCategoryController::class, 'edit'])
    ->name('admin.category.edit');

    Route::post('admin/category/{productCategory}/edit/confirm', [AdminCategoryController::class, 'editConfirm'])
    ->name('admin.category.edit.confirm');

    Route::patch('admin/category/{productCategory}', [AdminCategoryController::class, 'update'])
    ->name('admin.category.update');

    Route::delete('admin/category/{productCategory}', [AdminCategoryController::class, 'destroy'])
    ->name('admin.category.destroy');

});


/**
 * 管理者　商品管理
 */

Route::middleware('auth:admin')->group(function () {

    Route::get('admin/product/index', [AdminProductController::class, 'index'])
    ->name('admin.product.index');

    Route::get('admin/product/create', [AdminProductController::class, 'create'])
    ->name('admin.product.create');

    Route::post('admin/product/create/confirm', [AdminProductController::class, 'createConfirm'])
    ->name('admin.product.create.confirm');

    Route::post('admin/product/store', [AdminProductController::class, 'store'])
    ->name('admin.product.store');

    Route::get('admin/product/show/{product}', [AdminProductController::class, 'show'])
    ->name('admin.product.show');

    Route::get('admin/product/{productModel}/edit', [AdminProductController::class, 'edit'])
    ->name('admin.product.edit');

    Route::post('admin/product/{product}/edit/confirm', [AdminProductController::class, 'editConfirm'])
    ->name('admin.product.edit.confirm');

    Route::patch('admin/product/{product}', [AdminProductController::class, 'update'])
    ->name('admin.product.update');

    Route::delete('admin/product/{product}', [AdminProductController::class, 'destroy'])
    ->name('admin.product.destroy');

    // 画像用のルート（Ajax）
    Route::post('admin/product/upload', [ProductController::class, 'upload'])
    ->name('admin.product.upload');

});


/**
 * 管理者　レビュー管理
 */

Route::middleware('auth:admin')->group(function () {

    Route::get('admin/review/index', [AdminReviewController::class, 'index'])
    ->name('admin.review.index');

    Route::get('admin/review/create', [AdminReviewController::class, 'create'])
    ->name('admin.review.create');

    Route::post('admin/review/create/confirm', [AdminReviewController::class, 'createConfirm'])
    ->name('admin.review.create.confirm');

    Route::post('admin/review/store', [AdminReviewController::class, 'store'])
    ->name('admin.review.store');

    Route::get('admin/review/show/{review}', [AdminReviewController::class, 'show'])
    ->name('admin.review.show');

    Route::get('admin/review/{reviewModel}/edit', [AdminReviewController::class, 'edit'])
    ->name('admin.review.edit');

    Route::post('admin/review/{review}/edit/confirm', [AdminReviewController::class, 'editConfirm'])
    ->name('admin.review.edit.confirm');

    Route::patch('admin/review/{review}', [AdminReviewController::class, 'update'])
    ->name('admin.review.update');

    Route::delete('admin/review/{review}', [AdminReviewController::class, 'destroy'])
    ->name('admin.review.destroy');

});