<x-admin_layout>
<header  class="header_admin">
  <h1>{{ $mode === 'create' ? '商品レビュー登録' : '商品レビュー編集' }}</h1>

  <div>
    <a href="{{ session('admin_review_index_url', route('admin.review.index')) }}">一覧へ戻る</a>  
  </div>
</header>

<div class="contents">

  <div class="wrapper500">
  
    @if ($mode === 'create')
      <form action="{{ route('admin.review.create.confirm') }}" method="post">
    @else
      <form action="{{ route('admin.review.edit.confirm', $review['id']) }}" method="post">
    @endif

      @csrf

      <div class="div_form_inputs">

        <table class="confirm_table">
          <tr>
            <th>商品</th>
            <td>
              <select name="product_id" class="input_250">
                <option value="">--選択してください--</option>
                @foreach ($products as $product)
                  <option value="{{ $product->id }}" @selected(old('product_id', $review['product_id'] ?? '') == $product->id) required>
                    {{ $product->name }}
                  </option>
                @endforeach
              </select>
              <div class="error_wrapper_td">
                @error('product_id')
                  <p>※{{ $message }}</p>
                @enderror
              </div>                             
            </td>
          </tr>
          <tr>
            <th>会員</th>
            <td>
              <select name="member_id" class="input_250">
                <option value="">--選択してください--</option>
                @foreach ($users as $user)
                  <option value="{{ $user->id }}" @selected(old('member_id', $review['member_id'] ?? '') == $user->id) required>
                    {{ $user->name_sei }} {{ $user->name_mei }}
                  </option>
                @endforeach
              </select>
              <div class="error_wrapper_td">
                @error('member_id')
                  <p>※{{ $message }}</p>
                @enderror
              </div>                             
            </td>
          </tr>
          <tr>
            <th>ID</th>
            <td>
              @if ($mode === 'create')
                <p>登録後に自動採番</p>
              @else
                <p>{{ $review['id'] }}</p>
              @endif
              <div class="error_wrapper_td">
              </div>       
            </td>
          </tr>
          <tr>
            <th>商品評価</th>
            <td>
              <select name="evaluation" required class="input_250">
                <option value="">--選択してください--</option>
                @for($i = 1; $i <= 5; $i++)
                  <option value="{{ $i }}" @selected(old('evaluation', $review['evaluation'] ?? '') == $i)>
                    {{ $i }}
                  </option>
                @endfor 
              </select>
              <div class="error_wrapper_td">
                @error('evaluation')
                  <p>※{{ $message }}</p>
                @enderror
              </div>   
            </td>
          </tr>
          <tr>
            <th>商品コメント</th>
            <td>
              <textarea name="comment" class="text_250" required>{{ old('comment', $review['comment'] ?? '') }}</textarea>
              <div class="error_wrapper_td">
                @error('comment')
                  <p>※{{ $message }}</p>
                @enderror
              </div>   
            </td>
          </tr>
        </table>

      </div>

      <div class="div_tac">
        <input type="submit" value="確認画面へ" class="white_blue_submit">
      </div>

    </form>
  </div>

</div>

</x-admin_layout>