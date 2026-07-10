<x-layout>
  <form action="{{ route('mypage.updatepassword') }}" method="post">
    @csrf
    @method('patch')

    <label>パスワード</label>
    <input type="text" name="password">
    <label>パスワード確認</label>
    <input type="text" name="password_confirmation">
    
    <input type="submit" value="パスワードを変更">
  </form>

  @if($errors->any())
    <ul style="color:red">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif

  <a href="{{ route('mypage') }}">マイページに戻る</a>

</x-layout>