<x-layout>
<div class="contents">
    <h1>会員情報変更確認画面</h1>

    <div class="wrapper500">

      <table class="confirm_table">
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
      </table>

      <form action="{{ route('mypage.update') }}" method="POST">
        @csrf
        @method('patch')
        <div class="div_tac">
          <input type="submit" value="変更完了">
        </div>
      </form>

    </div>

      <div class="div_tac">
        <a href="{{ route('mypage.edit') }}" class="white_btn">前に戻る</a>  
      </div>

</div>
</x-layout>