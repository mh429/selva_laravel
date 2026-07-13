<x-admin_layout>
<header  class="header_admin">
  <h1>{{ $mode === 'create' ? '会員登録' : '会員編集' }}</h1>

  <div>
    <a href="{{ session('admin_member_index_url', route('admin.member.index')) }}">一覧へ戻る</a>  
  </div>
</header>

<div class="contents">

  <div class="wrapper500">

    <table class="confirm_table">
      <tr>
        <th>ID</th>
        <td>{{ $mode === 'create' ? '登録後に自動採番' : $user->id }}</td>
      </tr>
      <tr>
        <th>氏名</th>
        <td>{{ $data['name_sei']. "　". $data['name_mei'] }}</td>
      </tr>
      <tr>
        <th>ニックネーム</th>
        <td>{{ $data['nickname'] }}</td>
      </tr>
      <tr>
        <th>性別</th>
        <td>{{ config('master.gender')[$data['gender']] }}</td>
      </tr>
      <tr>
        <th>パスワード</th>
        <td>セキュリティのため非表示</td>
      </tr>
      <tr>
        <th>メールアドレス</th>
        <td>{{ $data['email'] }}</td>
      </tr>
    </table>

    
    @if ($mode === 'create')
    <form action="{{ route('admin.member.store') }}" method="POST">
      @csrf
      <div class="div_tac">
        <input type="submit" value="登録完了" class="white_blue_submit" onclick="this.disabled=true; this.form.submit();">
      </div>
    </form>

    @else
    <form action="{{ route('admin.member.update', $user->id) }}" method="post">
      @csrf
      @method('patch')
      <div class="div_tac">
        <input type="submit" value="編集完了" class="white_blue_submit" onclick="this.disabled=true; this.form.submit();">
      </div>
    </form>
    @endif

  </div>

  <div class="div_tac pb_10">
    
    @if ($mode === 'create')
      <a href="{{ route('admin.member.create') }}" class="white_blue_btn">前に戻る</a>
    @else
      <a href="{{ route('admin.member.edit', $user->id) }}" class="white_blue_btn">前に戻る</a>
    @endif
  </div>

</div>
</x-admin_layout>