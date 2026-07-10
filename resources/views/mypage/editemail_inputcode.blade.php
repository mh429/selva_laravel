<x-layout>
  <div>
    <h1>メールアドレス変更　認証コード入力</h1>

    <p>（※メールアドレスの変更はまだ完了していません）</p>
    <p>変更後のメールアドレスにお送りしましたメールに記載されている「認証コード」を入力してください。</p>

    <form action="{{ route('mypage.updateemail') }}" method="post">
      @csrf
      @method('patch')

      <div>
        <label>
        <p>認証コード</p>    
        <input type="number" name="auth_code" required>
        </label>
      </div>
      @error('auth_code')
        <p style="color:red">{{ $message }}</p>
      @enderror

      <input type="submit" value="認証コードを送信してメールアドレスの変更を完了する">

    </form>    

    <a href="{{ route('mypage') }}">マイページに戻る</a>
  </div>
</x-layout>