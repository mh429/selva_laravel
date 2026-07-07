<x-layout>

  <div class="contents">

    <h1>会員情報登録</h1>

    <div class="wrapper500">
      <form action="{{ route('member.confirm') }}" method="post">
        @csrf

        <div class="div_form_inputs">

          <div class="names_input_wrapper">
            <p>氏名</p>
            <label class="name_input_wrapper">
              <p>姓</p>
              <input type="text" name="name_sei" value="{{ old('name_sei', $member['name_sei'] ?? '') }}" required>
            </label>
            <label class="name_input_wrapper">
              <p>名</p>
              <input type="text" name="name_mei" value="{{ old('name_mei', $member['name_mei'] ?? '') }}" required>
            </label>    
          </div>
          <div class="error_wrapper">
            @error('name_sei')
              <p style="color:red">※{{ $message }}</p>
            @enderror
            @error('name_mei')
              <p style="color:red">※{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="input_wrapper">
            <p>ニックネーム</p>    
            <input type="text" name="nickname" value="{{ old('nickname', $member['nickname'] ?? '') }}" required class="input_250">
            </label>
          </div>
          <div class="error_wrapper">
            @error('nickname')
              <p style="color:red">※{{ $message }}</p>
            @enderror
          </div>

          <div class="gender_input_wrapper">
            <p>性別</p>    
              @foreach (config('master.gender') as $key => $value)
                <label>
                  <input type="radio" name="gender" value="{{ $key }}" @checked(old('gender', $member['gender'] ?? '') == $key) required>
                    {{ $value }}
                </label>
              @endforeach
          </div>
          <div class="error_wrapper">
            @error('gender')
              <p style="color:red">※{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="input_wrapper">
            <p>パスワード</p>    
            <input type="text" name="password" required class="input_250 mask">
            </label>
          </div>

          <div>
            <label class="input_wrapper">
            <p>パスワード確認</p>    
            <input type="text" name="password_confirmation" required class="input_250 mask">
            </label>
          </div>
          <div class="error_wrapper">
            @error('password')
              <p style="color:red">※{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="input_wrapper">
            <p>メールアドレス</p>    
            <input type="text" name="email" value="{{ old('email', $member['email'] ?? '') }}" required class="input_250">
            </label>
          </div>
          <div class="error_wrapper">
            @error('email')
              <p style="color:red">※{{ $message }}</p>
            @enderror
          </div>

        </div>

        <div class="div_tac">
          <input type="submit" value="確認画面へ">
        </div>

      </form>
    </div>

    <div class="div_tac">
      <a href="/" class="white_btn">トップに戻る</a>
    </div>

  </div>

</x-layout>