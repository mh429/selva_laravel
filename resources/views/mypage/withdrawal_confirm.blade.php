<x-layout>
<header>
  <div>
    <h1>マイページ</h1>
  </div>
  <div class="header_left">
    <a href="/">トップに戻る</a>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <input type="submit" value="ログアウト">
    </form>           
  </div>
</header>

<div class="contents">

  <div class="wrapper500 div_tac">
    <p class="pb_40">退会します。よろしいですか？</p>

    <div class="pb_20">
      <a href="{{ route('mypage') }}" class="white_blue_btn">マイページに戻る</a>
    </div>
    
    <form action="{{ route('mypage.withdrawal') }}" method="post">
      @csrf
      <input type="submit" value="退会する" class="blue_submit" onclick="this.disabled=true; this.form.submit();">
    </form>
  </div>

</div>
</x-layout>