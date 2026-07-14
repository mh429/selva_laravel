<x-admin_layout>
<header  class="header_admin">
  <h1>{{ $mode === 'create' ? '会員登録' : '会員編集' }}</h1>

  <div>
    <a href="{{ session('admin_member_index_url', route('admin.member.index')) }}">一覧へ戻る</a>  
  </div>
</header>

<div class="contents">

  <div class="wrapper500">
  
    @if ($mode === 'create')
      <form action="{{ route('admin.member.create.confirm') }}" method="post">
    @else
      <form action="{{ route('admin.member.edit.confirm', $member['id']) }}" method="post">
    @endif

      @csrf

      <div class="div_form_inputs">

        <div>
          <label class="member_id_wrapper">
          <p>ID</p>    
          @if ($mode === 'create')
            <p>登録後に自動採番</p>
          @else
            <p>{{ $member['id'] }}</p>
          @endif
          </label>
        </div>

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
            <p>※{{ $message }}</p>
          @enderror
          @error('name_mei')
            <p>※{{ $message }}</p>
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
            <p>※{{ $message }}</p>
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
            <p>※{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="input_wrapper">
          <p>パスワード</p>    
          <input type="text" name="password" class="input_250 mask" {{ $mode === 'create' ? 'required' : '' }}>
          </label>
        </div>

        <div>
          <label class="input_wrapper">
          <p>パスワード確認</p>    
          <input type="text" name="password_confirmation" class="input_250 mask" {{ $mode === 'create' ? 'required' : '' }}>
          </label>
        </div>
        <div class="error_wrapper">
          @error('password')
            <p>※{{ $message }}</p>
          @enderror
          @error('password_confirmation')
            <p>※{{ $message }}</p>
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
            <p>※{{ $message }}</p>
          @enderror
        </div>

      </div>

      <div class="div_tac">
        <input type="submit" value="確認画面へ" class="white_blue_submit">
      </div>

    </form>
  </div>

</div>
</x-admin_layout>