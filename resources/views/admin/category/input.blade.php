<x-admin_layout>
<header  class="header_admin">
  <h1>{{ $mode === 'create' ? '商品カテゴリ登録' : '商品カテゴリ編集' }}</h1>

  <div>
    <a href="{{ session('admin_category_index_url', route('admin.category.index')) }}">一覧へ戻る</a>  
  </div>
</header>

<div class="contents">

  <div class="wrapper550">
  
    @if ($mode === 'create')
      <form action="{{ route('admin.category.create.confirm') }}" method="post">
    @else
      <form action="{{ route('admin.category.edit.confirm', $category['id']) }}" method="post">
    @endif

      @csrf

        <table class="category_input_table">
          <tr>
            <th>商品大カテゴリID</th>
            <td>
              @if ($mode === 'create')
                <p>登録後に自動採番</p>
              @else
                <p>{{ $category['id'] }}</p>
              @endif
            </td>
          </tr>
          <tr>
            <th>商品大カテゴリ</th>
            <td>
              <input type="text" name="name" value="{{ old('name', $category['name'] ?? '') }}" required class="input_250">
              <div class="error_wrapper_td">
                @error('name')
                  <p>※{{ $message }}</p>
                @enderror
              </div>                               
            </td>
          </tr>
          <tr>
            <th style="vertical-align: top;">商品小カテゴリ</th>
            <td>
              @error('subcategory')
                <p class="error_wrapper_td">※{{ $message }}</p>
              @enderror                
              @for ($i = 1; $i <= 10; $i++)
                <div>
                  <input type="text" name="subcategory{{ $i }}" value="{{ old('subcategory'.$i, $category['subcategory'.$i] ?? '') }}" class="input_250">
                </div>
                <div class="error_wrapper_td">
                  @error('subcategory'.$i)
                    <p>※{{ $message }}</p>
                  @enderror
                </div>   
              @endfor

            </td>
          </tr>
        </table>

      <div class="div_tac">
        <input type="submit" value="確認画面へ" class="white_blue_submit">
      </div>

    </form>
  </div>

</div>

</x-admin_layout>