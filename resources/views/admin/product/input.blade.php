<x-admin_layout>
<header  class="header_admin">
  <h1>{{ $mode === 'create' ? '商品登録' : '商品編集' }}</h1>

  <div>
    <a href="{{ session('admin_product_index_url', route('admin.product.index')) }}">一覧へ戻る</a>  
  </div>
</header>

<div class="contents">

  <div class="wrapper500">
  
    @if ($mode === 'create')
      <form action="{{ route('admin.product.create.confirm') }}" method="post">
    @else
      <form action="{{ route('admin.product.edit.confirm', $product['id']) }}" method="post">
    @endif

      @csrf

      <div class="div_form_inputs">

        <table class="confirm_table">
          <tr>
            <th>ID</th>
            <td>
              @if ($mode === 'create')
                <p>登録後に自動採番</p>
              @else
                <p>{{ $product['id'] }}</p>
              @endif
            </td>
          </tr>
          <tr>
            <th>会員</th>
            <td>
              <select name="member_id">
                <option value="">--選択してください--</option>
                @foreach ($users as $user)
                  <option value="{{ $user->id }}" @selected(old('member_id', $product['member_id'] ?? '') == $user->id) required>
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
            <th>商品名</th>
            <td>
              <input type="text" name="name" value="{{ old('name', $product['name'] ?? '') }}" required class="input_250">
              <div class="error_wrapper_td">
                @error('name')
                  <p>※{{ $message }}</p>
                @enderror
              </div>   
            </td>
          </tr>
          <tr>
            <th>商品カテゴリ</th>
            <td>
              <div class="categories_wrapper">
                <select id="category" name="product_category_id" required>
                  <option value="">---カテゴリ---</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('product_category_id', $product['product_category_id'] ?? '') == $category->id)>
                      {{ $category->name }}
                    </option>
                  @endforeach  
                </select>  
                {{-- サブカテゴリの中身はJS側でAjax取得して作る。
                    data-selected には「以前選択していたID」を入れておき、取得後にJSでそのIDのoptionにselectedを付ける --}}
                <select id="subcategory" name="product_subcategory_id" required data-selected="{{ old('product_subcategory_id', $product['product_subcategory_id'] ?? '') }}" style="display:none;">
                </select>
              </div>     
              <div class="error_wrapper_td">
                @error('product_category_id')
                  <p>※{{ $message }}</p>
                @enderror
                @error('product_subcategory_id')
                  <p>※{{ $message }}</p>
                @enderror
              </div>    
            </td>
          </tr>
          <tr>
            <th style="vertical-align: top;">商品写真</th>
            <td>
            {{-- JSにアップロード用のルート名を渡す --}}
            <input
            type="hidden"
            id="upload_url"
            value="{{ route('admin.product.upload') }}">

            @for($i = 1; $i <= 4; $i++)
              <div>
                <p>写真{{ $i }}</p>
                <div class="preview_wrapper">
                  <img id="preview{{ $i }}" style="display:none; width:200px;">
                  <svg id="delete{{ $i }}" style="display:none" class="image_delete">
                      <circle cx="12" cy="12" r="10" fill="#ffffff" stroke="#000000" stroke-width="1.8"/>
                      <line x1="8" y1="8" x2="16" y2="16" stroke="#000000" stroke-width="1.8" stroke-linecap="round"/>
                      <line x1="16" y1="8" x2="8" y2="16" stroke="#000000" stroke-width="1.8" stroke-linecap="round"/>
                  </svg>
                </div>
                <input type="file" id="image_input_{{ $i }}" name="image_input_{{ $i }}" accept=".jpg, .jpeg, .png, .gif" class="file_button_none" style="display: none;">
                <label for="image_input_{{ $i }}" class="file_button">
                  アップロード
                </label>
                <input
                  type="hidden" id="image_{{ $i }}" name="image_{{ $i }}"
                  value="{{ old('image_'.$i, $product['image_'.$i] ?? '') }}"
                  data-url="{{ old('image_'.$i, $product['image_'.$i] ?? '') ? asset('storage/' . old('image_'.$i, $product['image_'.$i] ?? '')) : '' }}">
              </div>
              {{-- <div>
                <p>写真{{ $i }}</p>
                <img id="preview_admin{{ $i }}" style="display:none; max-width:200px;">          
                <input type="file" id="image_input_admin_{{ $i }}" name="image_input_admin_{{ $i }}" accept=".jpg, .jpeg, .png, .gif" class="file_button_none" style="display: none;">
                <label for="image_input_admin_{{ $i }}" class="file_button">
                  アップロード
                </label>
                <input
                  type="hidden" id="image_admin_{{ $i }}" name="image_admin_{{ $i }}"
                  value="{{ old('image_'.$i, $product['image_'.$i] ?? '') }}"
                  data-url="{{ old('image_'.$i, $product['image_'.$i] ?? '') ? asset('storage/' . old('image_'.$i, $product['image_'.$i] ?? '')) : '' }}">
              </div> --}}
              <div class="error_wrapper_td">
                <p id="image_error{{ $i }}"></p>               
              </div>                       
            @endfor            
            </td>
          </tr>
          <tr>
            <th>商品説明</th>
            <td>
              <textarea name="product_content" class="text_250" required>{{ old('product_content', $product['product_content'] ?? '') }}</textarea>
              <div class="error_wrapper_td">
                @error('product_content')
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