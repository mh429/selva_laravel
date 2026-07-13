
<x-admin_layout>
<header style="width: 800px; height:100px; background-color: #D0CECE">
</header>

<div class="contents">

  <h1>管理画面</h1>

  <div class="wrapper500">

    <form action="{{ route('admin.login') }}" method="post">
      @csrf

      <div class="div_form_inputs">
        <div>
          <label class="input_wrapper">
            <p>ログインID</p>
            <input type="text" name="login_id" value="{{ old('login_id') }}" class="input_250">
          </label>
        </div>
        <div>
          <label class="input_wrapper">
            <p>パスワード</p>
            <input type="text" name="password" class="input_250 mask">        
          </label>
        </div>

        <div class="error_wrapper">
          @if($errors->any())
            <p style="color: red">※{{ $errors->first() }}</p>
          @endif      
        </div>
      </div>

      <div class="div_tac">
        <input type="submit" value="ログイン" class="blue_submit" onclick="this.disabled=true; this.form.submit();">
      </div>

    </form>

  </div>

</div>

<footer class="footer_admin">
</footer>
</x-admin_layout>