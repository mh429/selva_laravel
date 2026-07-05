<x-layout>

  <h1>商品登録</h1>

  <form action="{{ route('product.confirm') }}" method="post">
    @csrf

    <div>
      <label>
      <p>商品名</p>    
      <input type="text" name="name" value="{{ old('name', $product['name'] ?? '') }}" required>
      </label>
    </div>
    @error('name')
      <p style="color:red">{{ $message }}</p>
    @enderror

    <div>
      <p>商品カテゴリ</p>
      <div>
        <select id="category" name="product_category_id" required>
          <option value="">選択してください</option>
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
    </div>
    @error('product_category_id')
      <p style="color:red">{{ $message }}</p>
    @enderror
    @error('product_subcategory_id')
      <p style="color:red">{{ $message }}</p>
    @enderror

    <div>
      <p>商品写真</p>    
      <div>
        @for($i = 1; $i <= 4; $i++)
          <div>
            <p>写真{{ $i }}</p>
            <img id="preview{{ $i }}" style="display:none; max-width:200px;">          
            <input type="file" id="image_input_{{ $i }}" name="image_input_{{ $i }}" accept=".jpg, .jpeg, .png, .gif">
            <input
              type="hidden" id="image_{{ $i }}" name="image_{{ $i }}"
              value="{{ old('image_'.$i, $product['image_'.$i] ?? '') }}"
              data-url="{{ old('image_'.$i, $product['image_'.$i] ?? '') ? asset('storage/' . old('image_'.$i, $product['image_'.$i] ?? '')) : '' }}"            >
            @error('image_'.$i)
              <p style="color:red">{{ $message }}</p>
            @enderror                   
          </div>
        @endfor
      </div>
    </div>

    <div>
      <label>
      <p>商品説明</p>   
      <textarea name="product_content" cols="30" rows="10" required>{{ old('product_content', $product['product_content'] ?? '') }}</textarea> 
      </label>
    </div>
    @error('product_content')
      <p style="color:red">{{ $message }}</p>
    @enderror

    <input type="submit" value="確認画面へ">

  </form>

  <a href="/">トップに戻る</a>

</x-layout>