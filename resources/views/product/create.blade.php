<x-layout>

  <div class="contents">

    <h1>商品登録</h1>

    <div class="wrapper500">
      <form action="{{ route('product.confirm') }}" method="post">
        @csrf

        <table class="confirm_table">
          <tr>
            <th>商品名</th>
            <td>
              <input type="text" name="name" value="{{ old('name', $product['name'] ?? '') }}" required class="input_300">
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
            <th>商品写真</th>
            <td>
            {{-- JSにアップロード用のルート名を渡す --}}
            <input
            type="hidden"
            id="upload_url"
            value="{{ route('product.upload') }}">

              @for($i = 1; $i <= 4; $i++)
                <div>
                  <p>写真{{ $i }}</p>
                  <img id="preview{{ $i }}" style="display:none; max-width:200px;">          
                  <input type="file" id="image_input_{{ $i }}" name="image_input_{{ $i }}" accept=".jpg, .jpeg, .png, .gif" class="file_button_none">
                  <label for="image_input_{{ $i }}" class="file_button">
                    アップロード
                  </label>
                  <input
                    type="hidden" id="image_{{ $i }}" name="image_{{ $i }}"
                    value="{{ old('image_'.$i, $product['image_'.$i] ?? '') }}"
                    data-url="{{ old('image_'.$i, $product['image_'.$i] ?? '') ? asset('storage/' . old('image_'.$i, $product['image_'.$i] ?? '')) : '' }}">
                </div>
                <div class="error_wrapper_td">
                  <p id="image_error{{ $i }}"></p>               
                </div>                       
              @endfor            
            </td>
          </tr>
          <tr>
            <th>商品説明</th>
            <td>
              <textarea name="product_content" cols="30" rows="10" required class="text_300">{{ old('product_content', $product['product_content'] ?? '') }}</textarea> 
              <div class="error_wrapper_td">
                @error('product_content')
                  <p>※{{ $message }}</p>
                @enderror          
              </div>
            </td>
          </tr>
        </table>

        <div class="div_tac">
          <input type="submit" value="確認画面へ">
        </div>
      
      </form>
    </div>

  @if(session('product_create_from') === 'top')
    <div class="div_tac">
      <a href="{{ route('top') }}" class="white_btn">トップに戻る</a>
    </div>
  @else
    <div class="div_tac">
      <a href="{{ route('product.index') }}" class="white_btn">商品一覧に戻る</a>
    </div>
  @endif

  </div>
</x-layout>