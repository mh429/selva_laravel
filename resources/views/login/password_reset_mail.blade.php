<x-layout>
  <header style="width: 800px; height:100px; background-color: #FBE4D5">
  </header>

  <form action="{{ route('sendPasswordResetMail') }}" method="post" style="margin-top:50px">
    @csrf
    <p>パスワード再設定用のURLを記載したメールを送信します。</p>
    <p>ご登録されたメールアドレスを入力してください。</p>
    <label>メールアドレス</label>
    <input type="text" name="email" value="{{ old('email') }}">

    @if($errors->any())
      <ul style="color:red">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    @endif

    <input type="submit" value="送信する">
  </form>  

  <a href="/">トップに戻る</a>
  
</x-layout>
