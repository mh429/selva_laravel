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
                'login_id' => ['required',],
                'password' => ['required',],
            ],
            [
                'login_id.required' => 'IDもしくはパスワードが間違っています。',
                'password.required' => 'IDもしくはパスワードが間違っています。',
            ]
        );

        if (Auth::guard('admin')->attempt($data)) {

            $request->session()->regenerate();

            return redirect()->route('admin.index');
        }

        return back()->withErrors([
            'login_id' => 'IDもしくはパスワードが間違っています。'
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
