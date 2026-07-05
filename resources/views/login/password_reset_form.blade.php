<x-layout>
  <header style="width: 800px; height:100px; background-color: #FBE4D5">
  </header>

  <form action="" method="post">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">

    <label>パスワード</label>
    <input type="text" name="password">
    <label>パスワード（確認）</label>
    <input type="text" name="password_confirmation">
    
    <input type="submit" value="パスワードリセット">
  </form>

  @if($errors->any())
    <ul style="color:red">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif

  <a href="/">トップに戻る</a>

</x-layout>