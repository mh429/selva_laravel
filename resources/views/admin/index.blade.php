<x-admin_layout>
<header class="header_admin">
  <h1>管理画面メインメニュー</h1>

  <div class="header_left">
    <p>ようこそ {{ auth()->guard('admin')->user()->name }} さん</p>        
    <form action="{{ route('admin.logout') }}" method="post">
      @csrf
      <input type="submit" value="ログアウト" onclick="this.disabled=true; this.form.submit();"> 
    </form>      
  </div>
</header>

<div class="contents">

  <div class="wrapper500">

    <div class="admin_top">

      <a href="{{ route('admin.member.index') }}" class="white_blue_btn">会員一覧</a>
      <a href="{{ route('admin.category.index') }}" class="white_blue_btn">商品カテゴリ一覧</a>
      <a href="{{ route('admin.product.index') }}" class="white_blue_btn">商品一覧</a>
      <a href="{{ route('admin.review.index') }}" class="white_blue_btn">商品レビュー一覧</a>

    </div>

  </div>

</div>
</x-admin_layout>