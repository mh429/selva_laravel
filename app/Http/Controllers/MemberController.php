<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\MemberCreateMail;

class MemberController extends Controller
{
    public function create()
    {
        $member = session('member');

        return view('member.create', compact('member'));
    }

    public function confirm(Request $request)
    {
        $data = $request->validate(
        [
            'name_sei' => ['required', 'string', 'max:20',],
            'name_mei' => ['required', 'string', 'max:20',],
            'nickname' => ['required', 'string', 'max:10',],
            'gender' => ['required', 'integer', Rule::in(array_keys(config('master.gender')))],
            'password' => ['required', 'string', 'between:8,20', 'regex:/^[a-zA-Z0-9]+$/', 'confirmed',],
            'password_confirmation' => ['required', 'string', 'between:8,20', 'regex:/^[a-zA-Z0-9]+$/',],
            'email' => ['required', 'string', 'max:200', 'email', 'unique:members,email',],
        ],
        [
            'password.regex' => 'パスワードは半角英数字で入力してください。',
            'password_confirmation.regex' => 'パスワードは半角英数字で入力してください。',
        ]
        );

        session()->put('member', $data);

        return view('member.confirm', compact('data'));
    }

    public function store()
    {
        $data = session('member');
        if (!$data) {
            return redirect()->route('member.create');
        }

        $data['password'] = bcrypt($data['password']);
        User::create($data);
        
        session()->forget('member');

        Mail::to($data['email'])->send(new MemberCreateMail($data));

        return view('member.store');
    }
}
