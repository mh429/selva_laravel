<x-layout>

  <h1>会員情報確認画面</h1>

  <table>
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
    <input type="submit" value="登録完了">
  </form>

  <a href="{{ route('member.create') }}">前に戻る</a>
</x-layout>