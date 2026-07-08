<x-layout>
  <header></header>

  <div class="contents">

    <div class="wrapper500">

    <form action="" method="post">
      @csrf

      <input type="hidden" name="token" value="{{ $token }}">
      <input type="hidden" name="email" value="{{ $email }}">

      <div class="div_form_inputs">
        <label class="input_wrapper">
          <p>パスワード</p>
          <input type="text" name="password" required class="input_250 mask">    
        </label>

        <label class="input_wrapper">
          <p>パスワード（確認）</p>
          <input type="text" name="password_confirmation" required class="input_250 mask">    
        </label>

        <div class="error_wrapper">
          @if($errors->any())
            <ul style="color:red">
              @foreach ($errors->all() as $error)
                <li>※{{ $error }}</li>
              @endforeach
            </ul>
          @endif
        </div>
      </div>
        
      <div class="div_tac">
        <input type="submit" value="パスワードリセット" onclick="this.disabled=true; this.form.submit();">
      </div>
    </form>

    </div>

    <div class="div_tac">
      <a href="/" class="white_btn">トップに戻る</a>
    </div>

  </div>

</x-layout>