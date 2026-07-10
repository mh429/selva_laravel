<x-layout>
  <header style="width: 800px; height:100px; background-color: #FBE4D5">
    <div>
      <h1>マイページ</h1>
    </div>
    <div>
      <a href="/">トップに戻る</a>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">ログアウト</button>
      </form>           
    </div>
  </header>

  <div>
    <div>
      <table>
        <tr>
          <th>氏名</th>
          <td>{{ $member->name_sei }}　{{ $member->name_mei }}</td>
        </tr>
        <tr>
          <th>ニックネーム</th>
          <td>{{ $member->nickname }}</td>
        </tr>
        <tr>
          <th>性別</th>
          <td>{{ config('master.gender')[$member->gender] }}</td>
        </tr>
      </table>
      <a href="{{ route('mypage.edit') }}">会員情報変更</a>      
    </div>

    <div>
      <table>
        <tr>
          <th>パスワード</th>
          <td>セキュリティのため非表示</td>
        </tr>
      </table>
      <a href="{{ route('mypage.editpassword') }}">パスワード変更</a>      
    </div>

    <div>
      <table>
        <tr>
          <th>メールアドレス</th>
          <td>{{ $member->email }}</td>
        </tr>
      </table>
      <a href="{{ route('mypage.editemail') }}">メールアドレス変更</a>      
    </div>

    <a href="{{ route('mypage.review') }}">商品レビュー管理</a>

    <a href="{{ route('mypage.withdrawalconfirm') }}">退会する</a>
  </div>
</x-layout>