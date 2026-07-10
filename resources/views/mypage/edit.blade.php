<x-layout>
  <div>
    <h1>会員情報登録</h1>

  <form action="{{ route('mypage.edit.confirm') }}" method="post">
    @csrf

    <div>
      <p>氏名</p>
      <label>
        <p>姓</p>
        <input type="text" name="name_sei" value="{{ old('name_sei', $member['name_sei'] ?? '') }}" required>
      </label>
      <label>
        <p>名</p>
        <input type="text" name="name_mei" value="{{ old('name_mei', $member['name_mei'] ?? '') }}" required>
      </label>    
    </div>
    @error('name_sei')
      <p style="color:red">{{ $message }}</p>
    @enderror
    @error('name_mei')
      <p style="color:red">{{ $message }}</p>
    @enderror

    <div>
      <label>
      <p>ニックネーム</p>    
      <input type="text" name="nickname" value="{{ old('nickname', $member['nickname'] ?? '') }}" required>
      </label>
    </div>
    @error('nickname')
      <p style="color:red">{{ $message }}</p>
    @enderror

    <div>
      <p>性別</p>    
        @foreach (config('master.gender') as $key => $value)
          <label>
            <input type="radio" name="gender" value="{{ $key }}" @checked(old('gender', $member['gender'] ?? '') == $key) required>
              {{ $value }}
          </label>
        @endforeach
    </div>
    @error('gender')
      <p style="color:red">{{ $message }}</p>
    @enderror

    <input type="submit" value="確認画面へ">

  </form>    


    <a href="{{ route('mypage') }}">マイページに戻る</a>
  </div>
</x-layout>