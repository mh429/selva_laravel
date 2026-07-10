<x-layout>
<div class="contents">

  <h1>メールアドレス変更　認証コード入力</h1>

  <div class="wrapper500">

    <p>（※メールアドレスの変更はまだ完了していません）</p>
    <p class="pb_40">変更後のメールアドレスにお送りしましたメールに記載されている「認証コード」を入力してください。</p>

    <form action="{{ route('mypage.updateemail') }}" method="post">
      @csrf
      @method('patch')

      <div class="div_form_inputs">
        <div>
          <label class="input_wrapper">
          <p>認証コード</p>    
          <input type="number" name="auth_code" required class="input250">
          </label>
        </div>
        <div class="error_wrapper">
          @error('auth_code')
            <p style="color:red">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="div_tac">
        <input type="submit" value="認証コードを送信してメールアドレスの変更を完了する" class="submit_fit">
      </div>

    </form>    
  </div>

</div>
</x-layout>