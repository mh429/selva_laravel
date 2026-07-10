<x-layout>
<div class="contents">
  <h1>会員情報変更</h1>

  <div class="wrapper500">

    <form action="{{ route('mypage.edit.confirm') }}" method="post">
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
            <p style="color:red">{{ $message }}</p>
          @enderror
          @error('name_mei')
            <p style="color:red">{{ $message }}</p>
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
            <p style="color:red">{{ $message }}</p>
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
            <p style="color:red">{{ $message }}</p>
          @enderror
        </div>

      </div>

      <div class="div_tac">
        <input type="submit" value="確認画面へ">
      </div>
      
    </form>    

  </div>

  <div class="div_tac">
    <a href="{{ route('mypage') }}" class="white_btn">マイページに戻る</a>
  </div>
    
</div>
</x-layout>