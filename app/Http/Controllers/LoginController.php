<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class LoginController extends Controller
{
    // ログイン画面表示
    public function showLoginForm()
    {
        return view('login.login');
    }


    // ログイン処理
    public function login(Request $request)
    {
        $data = $request->validate(
            [
                'email' => ['required',],
                'password' => ['required',],
            ],
            [
                'email.required' => 'IDもしくはパスワードが間違っています。',
                'password.required' => 'IDもしくはパスワードが間違っています。',
            ]
        );

        if (Auth::attempt($data)) {
            $request->session()->regenerate();

            return to_route('top');
        }

        return back()->withErrors([
            'email' => 'IDもしくはパスワードが間違っています。'
        ])->onlyInput('email');
    }


    // ログアウト処理
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('top');
    }


    // パスワード再設定メール送信フォーム表示
    public function showPasswordResetMailForm()
    {
        return view('login.password_reset_mail');
    }


    // パスワード再設定メール送信
    public function sendPasswordResetMail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:members,email',
            ],
        ], [
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => 'メールアドレスの形式が正しくありません。',
            'email.exists' => 'このメールアドレスは登録されていません。',
        ]);

        // リクエストされたメールアドレスで送信処理を実行
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return view('login.password_reset_mail_sent');
        }

        return back()->withErrors([
            'mail' => 'パスワード再設定メールの送信に失敗しました。',
        ]);
    }


    // パスワード再設定メールのURLをクリックした時
    public function showPasswordResetForm(Request $request, string $token)
    {
        return view('login.password_reset_form', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }


    // パスワード再設定処理
    public function passwordReset(Request $request)
    {
        $request->validate(
            [
                'email' => ['required',],
                'token' => ['required',],
                'password' => ['required', 'string', 'between:8,20', 'regex:/^[a-zA-Z0-9]+$/', 'confirmed',],
                'password_confirmation' => ['required', 'string', 'between:8,20', 'regex:/^[a-zA-Z0-9]+$/',],
            ],
            [
                'email.required' => 'ユーザーが存在しません。',
                'token.required' => 'トークンが無効です。',
                'password.regex' => 'パスワードは半角英数字で入力してください。',
                'password_confirmation.regex' => 'パスワード確認は半角英数字で入力してください。',
            ]
        );

        $loginUser = null;

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) use (&$loginUser) {
                $user->password = bcrypt($password);
                $user->save();
                $loginUser = $user;
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            Auth::login($loginUser);
            $request->session()->regenerate();

            return to_route('top');
        }

        return back()->withErrors([
            'reset' => 'パスワードの再設定に失敗しました。',
        ]);
    }
}


