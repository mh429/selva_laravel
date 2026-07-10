<x-layout>
<div class="contents">
  <h1>パスワード変更</h1>

  <div class="wrapper500">

    <form action="{{ route('mypage.updatepassword') }}" method="post">
      @csrf
      @method('patch')

      <div class="div_form_inputs">
        <label class="input_wrapper">
          <p>パスワード</p>
          <input type="text" name="password" required class="input_250">
        </label>
        <label class="input_wrapper">
          <p>パスワード確認</p>
          <input type="text" name="password_confirmation" required class="input_250">
        </label>
        <div class="error_wrapper">
          @if($errors->any())
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          @endif
        </div>
      </div>
      
      <div class="div_tac">
        <input type="submit" value="パスワードを変更">
      </div>
    </form>

  </div>

  <div class="div_tac">
    <a href="{{ route('mypage') }}" class="white_btn">マイページに戻る</a>
  </div>

</div>
</x-layout>