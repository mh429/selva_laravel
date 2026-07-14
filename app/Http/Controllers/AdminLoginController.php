<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    // ログイン画面表示
    public function showLoginForm()
    {
        return view('admin.login');
    }


    // ログイン処理
    public function login(Request $request)
    {
        $data = $request->validate(
            [
                'login_id' => ['required', 'between:7,10', 'regex:/^[a-zA-Z0-9]+$/',],
                'password' => ['required', 'between:8,20', 'regex:/^[a-zA-Z0-9]+$/',],
            ],
            [
                'login_id.regex' => 'ログインIDは半角英数字で入力してください。',
                'password.regex' => 'パスワードは半角英数字で入力してください。',
            ]
        );

        if (Auth::guard('admin')->attempt($data)) {

            $request->session()->regenerate();

            return redirect()->route('admin.index');
        }

        return back()->withErrors([
            'password' => 'IDもしくはパスワードが間違っています。'
        ])->onlyInput('login_id');
    }


    // ログアウト処理
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // $request->session()->regenerate();

        return to_route('admin.login');
    }


    // 管理者トップ画面表示
    public function index()
    {
        return view('admin.index');
    }
}
