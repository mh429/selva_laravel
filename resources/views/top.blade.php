<x-layout>
  <header style="width: 800px; height:100px; background-color: #FBE4D5">
    @auth
      <p>{{ auth()->user()->name_sei }} {{ auth()->user()->name_mei }}様</p>
      <div>
        <a href="">商品一覧</a>
        <a href="{{ route('product.create') }}">新規商品登録</a>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit">ログアウト</button>
        </form>            
      </div>
    @else
      <div>
        <a href="">商品一覧</a>
        <a href="{{ route('member.create') }}">新規会員登録</a>   
        <a href="{{ route('login') }}">ログイン</a> 
      </div>
    @endauth
  </header>

  <h1>TOP画面</h1>
</x-layout>