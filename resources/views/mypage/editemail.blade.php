<x-layout>
<div class="contents">
  <h1>メールアドレス変更</h1>

  <div class="wrapper500">

    <form action="{{ route('mypage.editemail.sendcode') }}" method="post">
      @csrf

      <div class="div_form_inputs">
        <div class="edit_email">
          <p>現在のメールアドレス</p>    
          <p>{{ $member->email }}</p>
        </div>
        <div>
          <label class="edit_email">
          <p>変更後のメールアドレス</p>    
          <input type="text" name="email" value="{{ old('email', '') }}" required class="input_250">
          </label>
        </div>
        <div class="error_wrapper">
          @error('email')
            <p style="color:red">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="div_tac">
        <input type="submit" value="認証メール送信">
      </div>
      
    </form>    

  </div>

  <div class="div_tac">
    <a href="{{ route('mypage') }}" class="white_btn">マイページに戻る</a>
  </div>

</div>
</x-layout>