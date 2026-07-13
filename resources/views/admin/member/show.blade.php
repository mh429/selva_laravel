<x-admin_layout>
<header  class="header_admin">
  <h1>会員詳細</h1>

  <div>
    <a href="{{ session('admin_member_index_url', route('admin.member.index')) }}">一覧へ戻る</a>  
  </div>
</header>

<div class="contents">

  <div class="wrapper500">

    <table class="confirm_table">
      <tr>
        <th>ID</th>
        <td>{{ $user->id }}</td>
      </tr>
      <tr>
        <th>氏名</th>
        <td>{{ $user->name_sei }}　{{ $user->name_mei }}</td>      
      </tr>
      <tr>
        <th>ニックネーム</th>
        <td>{{ $user->nickname }}</td>
      </tr>
      <tr>
        <th>性別</th>
        <td>{{ config('master.gender')[$user->gender] }}</td>      
      </tr>
      <tr>
        <th>パスワード</th>
        <td>セキュリティのため非表示</td>
      </tr>
      <tr>
        <th>メールアドレス</th>
        <td>{{ $user->email }}</td>
      </tr>
    </table>

  </div>

  <div class="wrapper500">

    <div class="admin_edit_delete_btn_wrapper pb_10">
      <a href="{{ route('admin.member.edit', $user->id) }}" class="white_blue_btn">編集</a>

      <form action="{{ route('admin.member.destroy', $user->id) }}" method="post">
        @csrf
        @method('delete')
        <input type="submit" value="削除" class="white_blue_submit" onclick="this.disabled=true; this.form.submit();">
      </form>
    </div>

  </div>

</div>  
</x-admin_layout>