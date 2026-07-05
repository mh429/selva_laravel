<x-layout>

  <h1>ログイン</h1>

  <form method="post">
    @csrf
    <p>
        <label>メールアドレス（ID）</label>
        <input type="text" name="email" value="{{ old('email') }}">
    </p>
    <p>
        <label>パスワード</label>
        <input type="password" name="password">
    </p>

    <a href="{{ route('showPasswordResetMailForm') }}">パスワードを忘れた方はこちら</a>

    @if($errors->any())
      <p style="color: red">{{ $errors->first() }}</p>
    @endif

    <input type="submit" value="ログイン">

  </form>

  <a href="/">トップに戻る</a>


</x-layout>