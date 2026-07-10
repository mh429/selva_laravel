<x-layout>
<header>
  <div>
    <h1>マイページ</h1>
  </div>
  <div class="header_left">
    <a href="/">トップに戻る</a>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <input type="submit" value="ログアウト" onclick="this.disabled=true; this.form.submit();">
    </form>           
  </div>
</header>

<div class="contents">

  <div class="wrapper500">
    <div>
      <table class="confirm_table">
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
      <div class="div_tac">
        <a href="{{ route('mypage.edit') }}" class="blue_btn">会員情報変更</a>  
      </div>
    </div>

    <div>
      <table class="confirm_table">
        <tr>
          <th>パスワード</th>
          <td>セキュリティのため非表示</td>
        </tr>
      </table>
      <div class="div_tac">
        <a href="{{ route('mypage.editpassword') }}" class="blue_btn">パスワード変更</a>  
      </div>
    </div>

    <div>
      <table class="confirm_table">
        <tr>
          <th>メールアドレス</th>
          <td>{{ $member->email }}</td>
        </tr>
      </table>
      <div class="div_tac pb_40">
        <a href="{{ route('mypage.editemail') }}" class="blue_btn" >メールアドレス変更</a>
      </div>
    </div>

    <div class="div_tac pb_40">
      <a href="{{ route('mypage.review') }}" class="blue_btn">商品レビュー管理</a>  
    </div>
    
    <div class="div_tac">
      <a href="{{ route('mypage.withdrawalconfirm') }}" class="white_blue_btn">退会</a>  
    </div>
  </div>

</div>
</x-layout>