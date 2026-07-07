<x-layout>

  <div class="contents">

    <h1>会員情報確認画面</h1>

    <div class="wrapper500">

      <table class="confirm_table">
        <tr>
          <th>氏名</th>
          <td>{{ $data['name_sei']. " ". $data['name_mei'] }}</td>
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

      <form action="{{ route('member.store') }}" method="POST">
        @csrf
        <div class="div_tac">
          <input type="submit" value="登録完了">
        </div>
      </form>

    </div>

    <div class="div_tac">
      <a href="{{ route('member.create') }}" class="white_btn">前に戻る</a>
    </div>
  </div>

</x-layout>