<x-layout>
<header style="width: 800px; height:100px; background-color: #FBE4D5">
  <h1>商品一覧</h1>
  @auth
    <div>
      <a href="{{ route('product.create', ['from' => 'index']) }}">新規商品登録</a>        
    </div>
  @endauth
</header>

<div class="contents">
  <div class="wrapper500">

    <div class="search_wrapper">
      <form action="" method="get">
        @csrf

        <table class="search_table">
          <tr>
            <th><p>カテゴリ</p></th>
            <td>
              <div class="categories_wrapper">
                <select id="category" name="product_category_id">
                  <option value="">選択してください</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(($product_search['product_category_id'] ?? '') == $category->id)>
                      {{ $category->name }}
                    </option>
                  @endforeach  
                </select>  
                {{-- サブカテゴリの中身はJS側でAjax取得して作る。
                    data-selected には「以前選択していたID」を入れておき、取得後にJSでそのIDのoptionにselectedを付ける --}}
                <select id="subcategory" name="product_subcategory_id" data-selected="{{ $product_search['product_subcategory_id'] ?? '' }}" style="display:none;">
                </select>
              </div>    
            </td>
          </tr>
          <tr>
            <th>フリーワード</th>
            <td>
              <input type="text" name="freeword" value="{{ $product_search['freeword'] ?? '' }}" class="input_250">
            </td>
          </tr>
        </table>
        <div class="div_tac">
          <input type="submit" value="商品検索" class="search_btn">
        </div>
      </form>
    </div>

    @foreach ($products as $product)
      <hr>
      <div class="product_wrapper_index">
        <div class="product_image_index">
          @if ($product->thumbnail)
            <img src="{{ asset('storage/' . $product->thumbnail) }}" style="width: 150px">
          @endif
        </div>
        <div>
          <p><span class="procudt_categories_index">{{ $product->category->name }}>{{ $product->subcategory->name }}</span></p>
          <p class="product_title_index"><a href="{{ route('product.show', $product) }}">{{ $product->name }}</a></p>
          <div>
            @if ($product->reviews_avg_evaluation)
              <div>
                @for ($i = 0; $i < ceil($product->reviews_avg_evaluation); $i++)
                  <span>★</span>
                @endfor
              </div>
              <p>{{ ceil($product->reviews_avg_evaluation) }}</p>
            @else
              <p></p>
            @endif
          </div>
        </div>
        <div class="product_detailbtn_index">
          <p><a href="{{ route('product.show', $product) }}" class="detail_btn">詳細</a></p>        
        </div>
      </div>
    @endforeach

    <div>
      <hr>
      <div class="pager_nav_wrapper">
        {{ $products->links('components.pagination') }}
      </div>
    </div>

  </div>
  <div class="div_tac">
    <a href="/" class="white_blue_btn">トップに戻る</a>
  </div>
</div>
</x-layout>