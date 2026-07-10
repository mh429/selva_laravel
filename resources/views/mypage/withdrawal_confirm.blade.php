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
    <p>退会します。よろしいですか？</p>

    <a href="{{ route('mypage') }}">マイページに戻る</a>
    <form action="{{ route('mypage.withdrawal') }}" method="post">
      @csrf
      <input type="submit" value="退会する">
    </form>
  </div>
</x-layout>