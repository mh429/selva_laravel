<x-layout>
  <header>
    @auth
      <p>ようこそ {{ auth()->user()->name_sei }} {{ auth()->user()->name_mei }}様</p>
      <div class="header_left">
        <!-- <a href="">商品一覧</a> -->
        <a href="{{ route('product.create') }}">新規商品登録</a>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <input type="submit" value="ログアウト">
        </form>            
      </div>
    @else
      <p></p>
      <div class="header_left">
        <!-- <a href="">商品一覧</a> -->
        <a href="{{ route('member.create') }}">新規会員登録</a>   
        <a href="{{ route('login') }}">ログイン</a> 
      </div>
    @endauth
  </header>

  
</x-layout>