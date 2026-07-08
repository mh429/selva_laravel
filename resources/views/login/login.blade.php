<x-layout>

  <div class="contents">

    <h1>ログイン</h1>

    <div class="wrapper500">
      <form method="post">
        @csrf

        <div class="div_form_inputs">
        <div>
          <label class="input_wrapper">
            <p>メールアドレス（ID）</p>
            <input type="text" name="email" value="{{ old('email') }}" required class="input_250">              
          </label>
        </div>
        <div>
          <label class="input_wrapper">
            <p>パスワード</p>
            <input type="text" name="password" required class="input_250 mask">              
          </label>
        </div>

        <div class="div_tac">
          <a href="{{ route('showPasswordResetMailForm') }}" class="pass_forget">パスワードを忘れた方はこちら</a>  
        </div>

        <div class="error_wrapper">
          @if($errors->any())
            <p style="color: red">※{{ $errors->first() }}</p>
          @endif
        </div>

        </div>

        <div class="div_tac">
          <input type="submit" value="ログイン" onclick="this.disabled=true; this.form.submit();">
        </div>

      </form>
    </div>

    <div class="div_tac">
      <a href="/" class="white_btn">トップに戻る</a>
    </div>

  </div>

</x-layout>