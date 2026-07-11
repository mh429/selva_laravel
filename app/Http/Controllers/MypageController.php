<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\MypageEmailUpdateMail;
use App\Models\Review;

class MypageController extends Controller
{
    /**
     * マイページ表示
     */

    public function mypage()
    {
        $member = Auth::user();
        return view('mypage.mypage', compact('member'));
    }

    /**
     * 退会
     */

    // 退会確認
    public function withdrawalConfirm()
    {
        return view('mypage.withdrawal_confirm');
    }
    // 退会
    public function withdrawal(Request $request)
    {
        $user = Auth::user();
        // ソフトデリート
        $user->delete();
        // ログアウト処理
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('top');
    }

    /**
     * 会員情報編集
     */

    // 編集画面
    public function edit()
    {
        $member = session('member.editing');
        if (!$member) {
            $member = Auth::user()->toArray();
        }

        return view('mypage.edit', compact('member'));
    }
    // 編集確認画面
    public function editConfirm(Request $request)
    {
        $data = $request->validate(
        [
            'name_sei' => ['required', 'string', 'max:20',],
            'name_mei' => ['required', 'string', 'max:20',],
            'nickname' => ['required', 'string', 'max:10',],
            'gender' => ['required', 'integer', Rule::in(array_keys(config('master.gender')))],
        ]
        );

        session()->put('member.editing', $data);

        return view('mypage.edit_confirm', compact('data'));
    }
    // DB登録
    public function update()
    {
        $data = session('member.editing', []);
        if (!$data) {
            return redirect()->route('top');
        }
        session()->forget('member.editing');        
 
        $member = Auth::user();
        $member->update([
            'name_sei' => $data['name_sei'],
            'name_mei' => $data['name_mei'],
            'nickname' => $data['nickname'],
            'gender' => $data['gender'],
        ]);
 
        return to_route('mypage');
    }

    /**
     * パスワード変更
     */

    // パスワード変更画面
    public function editPassword()
    {
        return view('mypage.editpassword');
    }
    // DB登録
    public function updatePassword(Request $request)
    {
        $data = $request->validate(
        [
            'password' => ['required', 'string', 'between:8,20', 'regex:/^[a-zA-Z0-9]+$/', 'confirmed',],
            'password_confirmation' => ['required', 'string', 'between:8,20', 'regex:/^[a-zA-Z0-9]+$/',],
        ],
        [
            'password.regex' => 'パスワードは半角英数字で入力してください。',
            'password_confirmation.regex' => 'パスワード確認は半角英数字で入力してください。',
        ]
        );

        $member = Auth::user();
        $member->update([
            'password' => bcrypt($data['password']),
        ]);        

        return to_route('mypage');
    }

    /**
     * メールアドレス変更
     */

    // メールアドレス変更画面
    public function editEmail()
    {
        $member = Auth::user();

        return view('mypage.editemail', compact('member'));
    }
    // 認証コード送信
    public function editEmailSendcode(Request $request)
    {
        $data = $request->validate(
        [
            'email' => ['required', 'string', 'max:200', 'email', 'unique:members,email',],
        ]
        );

        session()->put('member.editingemail', $data);

        // 認証コードを記載したメールを送信
        do {
            $auth_code = random_int(100000, 999999);
        } while (
            User::where('auth_code', $auth_code)->exists()
        );
        $member = Auth::user();
        $member->update([
            'auth_code' => $auth_code,
        ]);

        Mail::to($data['email'])->send(new MypageEmailUpdateMail($auth_code));

        return redirect()->route('mypage.editemail.inputcode');
    }

    // 認証コード入力画面を表示
    // back用にgetルートにする（Varidationを自作してpostのままにする方法もある）
    public function showEditEmailInputCode()
    {
        if (!session()->has('member.editingemail')) {
            return to_route('mypage.editemail');
        }

        return view('mypage.editemail_inputcode');
    }

    // DB登録
    public function updateEmail(Request $request)
    {
        // 認証コード確認
        $member = Auth::user();
        if ($request->auth_code != $member->auth_code) {
            return back()->withErrors([
                'auth_code' => '認証コードが違います。'
            ]);
        }

        $member->update([
            'email' => session('member.editingemail.email'),
            'auth_code' => null,
        ]);
 
        session()->forget('member.editingemail');     

        return to_route('mypage');
    }   

    /**
     * レビュー管理
     */

    // レビュー一覧
    public function review() 
    {
        $reviews = Auth::user()
            ->reviews()
            ->with([
                'product.category',
                'product.subcategory',
            ])
            ->latest('id')
            ->paginate(5);

        return view('mypage.review.index', compact('reviews'));
    }

    // レビュー編集
    public function reviewEdit(Review $review)
    {
        $review->load('product');
        $review->product->loadAvg('reviews', 'evaluation');

        $input = session("reviewedit.{$review->id}");

        return view('mypage.review.edit', compact('review', 'input'));
    }
    // レビュー編集確認
    public function reviewEditConfirm(Review $review, Request $request)
    {
        $data = $request->validate(
        [
            'evaluation' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:500',],
        ],
        [],
        [
            'comment' => '商品コメント',
        ]);

        session()->put("reviewedit.{$review->id}", $data);

        $review->load('product');
        $review->product->loadAvg('reviews', 'evaluation');

        return view('mypage.review.edit_confirm', compact('review', 'data'));
    }
    // DB登録
    public function reviewUpdate(Review $review)
    {
        abort_if($review->member_id !== Auth::id(), 403);

        $data = session("reviewedit.{$review->id}", []);
        if (!$data) {
            return redirect()->route('top');
        }
        session()->forget("reviewedit.{$review->id}");        
 
        $review->update($data);
 
        return to_route('mypage.review');
    }

    // レビュー削除確認
    public function reviewDeleteConfirm(Review $review)
    {
        $review->load('product');
        $review->product->loadAvg('reviews', 'evaluation');

        return view('mypage.review.delete_confirm', compact('review'));
    }
    // DB更新
    public function reviewDelete(Review $review)
    {
        abort_if($review->member_id !== Auth::id(), 403);
        
        // ソフトデリート
        $review->delete();

        return to_route('mypage.review');
    }
}
