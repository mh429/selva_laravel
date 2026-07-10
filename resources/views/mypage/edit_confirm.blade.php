<x-layout>
  <div>
    <h1>会員情報変更確認画面</h1>

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
    </table>

    <form action="{{ route('mypage.update') }}" method="POST">
      @csrf
      @method('patch')
      <input type="submit" value="登録完了">
    </form>

    <a href="{{ route('mypage.edit') }}">前に戻る</a>

  </div>
</x-layout>