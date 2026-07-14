<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class AdminMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // ID
        if ($request->filled('member_id')) {
            $query->where('id', $request->member_id);
        }

        // 性別
        if ($request->filled('gender')) {
            $gender = $request->input('gender');
            // 片方だけ選択されているときだけ絞り込み
            if (count($gender) === 1) {
                $query->where('gender', $gender[0]);
            }
        }

        // フリーワード
        if ($request->filled('freeword')) {
            $query->where(function ($q) use ($request) {
                $q->where('name_sei', 'like', '%' . $request->freeword . '%')
                ->orWhere('name_mei', 'like', '%' . $request->freeword . '%')
                ->orWhere('email', 'like', '%' . $request->freeword . '%');
            });
        }

        // ソート対象
        $sort = $request->input('sort', 'id');
        // 昇順・降順
        $order = $request->input('order', 'desc');

        // ソート可能なカラムを限定
        if (!in_array($sort, ['id', 'created_at'])) {
            $sort = 'id';
        }
        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }

        $query->orderBy($sort, $order);

        $members = $query->paginate(10)->withQueryString();


        // 検索条件をビューへ渡す
        $member_search = $request->only([
            'member_id',
            'gender',
            'freeword',
        ]);

        session(['admin_member_index_url' => url()->full()]);

        return view('admin.member.index', compact('members', 'member_search'));
    }

    public function create()
    {
        $member = session('admin.member.create');
        $mode = 'create';

        return view('admin.member.input', compact('member', 'mode'));
    }

    public function createConfirm(Request $request)
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
            'password_confirmation.regex' => 'パスワード確認は半角英数字で入力してください。',
        ]
        );

        session()->put('admin.member.create', $data);
        $mode = 'create';

        return view('admin.member.confirm', compact('data', 'mode'));
    }

    public function store()
    {
        $data = session('admin.member.create');
        if (!$data) {
            return redirect()->route('admin.member.create');
        }
        session()->forget('admin.member.create');

        $data['password'] = bcrypt($data['password']);
        User::create($data);

        return redirect(session('admin_member_index_url', route('admin.member.index')));
    }

    public function show(User $user)
    {
        return view('admin.member.show', compact('user'));
    }

    public function edit(User $user)
    {
        // $member = session("admin.member.edit.{$user->id}", $user->toArray());

        $member = session("admin.member.edit.{$user->id}");

        if (!$member) {
            $member = $user->toArray();
        } else {
            $member['id'] = $user->id;
        }

        $mode = 'edit';

        return view('admin.member.input', compact('member', 'mode'));
    }

    public function editConfirm(Request $request, User $user)
    {
        // 半角スペース8つだと通ってしまう対策
        if ($request->has('password')
            && $request->input('password') !== null
            && $request->input('password') !== ''
            && trim($request->input('password')) === '') {
            return back()
                ->withErrors([
                    'password' => 'パスワードは半角英数字で入力してください。',
                ])
                ->withInput();
        }

        $data = $request->validate(
        [
            'name_sei' => ['required', 'string', 'max:20',],
            'name_mei' => ['required', 'string', 'max:20',],
            'nickname' => ['required', 'string', 'max:10',],
            'gender' => ['required', 'integer', Rule::in(array_keys(config('master.gender')))],
            'password' => ['nullable', 'string', 'between:8,20', 'regex:/^[a-zA-Z0-9]+$/', 'confirmed',],
            'password_confirmation' => ['nullable', 'string', 'between:8,20', 'regex:/^[a-zA-Z0-9]+$/',],
            'email' => ['required', 'string', 'max:200', 'email', Rule::unique('members', 'email')->ignore($user->id),],
        ],
        [
            'password.regex' => 'パスワードは半角英数字で入力してください。',
            'password_confirmation.regex' => 'パスワード確認は半角英数字で入力してください。',
        ]
        );

        // dump($request->password);

        session()->put("admin.member.edit.{$user->id}", $data);
        $mode = 'edit';

        return view('admin.member.confirm', compact('data', 'mode', 'user'));
    }

    public function update(User $user)
    {
        $data = session("admin.member.edit.{$user->id}", []);
        if (!$data) {
            return redirect()->route('admin.index');
        }
        session()->forget("admin.member.edit.{$user->id}");
 
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);
 
        return redirect(session('admin_member_index_url', route('admin.member.index')));
    }

    public function destroy(User $user)
    {
        // ユーザーのレビューをソフトデリート
        $user->reviews()->delete();
        // ユーザーをソフトデリート
        $user->delete();

        return redirect(session('admin_member_index_url', route('admin.member.index')));
    }
}
