<x-layout>
  <header></header>

  <div class="contents">

    <div class="wrapper500">

      <form action="{{ route('sendPasswordResetMail') }}" method="post" style="margin-top:50px">
        @csrf
        <div class="pass_forget_messages">
          <p>パスワード再設定用のURLを記載したメールを送信します。</p>
          <p>ご登録されたメールアドレスを入力してください。</p>         
        </div>

        <div class="div_form_inputs">
          <label class="input_wrapper">
            <p>メールアドレス</p>
            <input type="text" name="email" value="{{ old('email') }}" required class="input_250">
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
          <input type="submit" value="送信する" onclick="this.disabled=true; this.form.submit();">
        </div>
      </form>  

    </div>

    <div class="div_tac">
      <a href="/" class="white_btn">トップに戻る</a>
    </div>

  </div>
</x-layout>
