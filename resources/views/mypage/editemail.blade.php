<x-layout>
  <div>
    <h1>メールアドレス変更</h1>

  <form action="{{ route('mypage.editemail.sendcode') }}" method="post">
    @csrf

    <div>
      <label>
      <p>現在のメールアドレス</p>    
      <p>{{ $member->email }}</p>
      </label>
    </div>
    <div>
      <label>
      <p>変更後のメールアドレス</p>    
      <input type="text" name="email" value="{{ old('email', '') }}" required>
      </label>
    </div>
    @error('email')
      <p style="color:red">{{ $message }}</p>
    @enderror

    <input type="submit" value="認証メール送信">

  </form>    


    <a href="{{ route('mypage') }}">マイページに戻る</a>
  </div>
</x-layout>