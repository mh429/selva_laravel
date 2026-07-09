<x-layout>
<header style="width: 800px; height:100px; background-color: #FBE4D5">
  <h1>商品詳細</h1>
  <div>
    <a href="/">トップに戻る</a>        
  </div>
</header>

<div class="contents">

  <div class="wrapper700">
    <div>
      <p>{{ $product->category->name }} > {{ $product->subcategory->name }}</p>
    </div>
    <div class="product_titles_show">
      <h2>{{ $product->name }}</h2>
      <p>更新日時：{{ $product->updated_at->format('Ymd') }}</p>
    </div>
    <div class="product_images_show">
      @if (!empty($product->images))
        @foreach ($product->images as $image)
          <img src="{{ asset('storage/' . $image) }}" style="width: 170px">
        @endforeach
      @endif
    </div>
    <div class="product_contents_show">
      <p class="pb_10">◾商品説明</p>
      <p>{!! nl2br(e($product->product_content)) !!}</p>
    </div>
    <div class="product_reviews_show">
      <p class="pb_10">◾商品レビュー</p>
      <div class="review_total pb_10">
        <p>総合評価</p>
        @if ($average)
          <div>
            @for ($i = 0; $i < ceil($average); $i++)
              <span>★</span>
            @endfor
          </div>
          <p>{{ ceil($average) }}</p>
          
        @else
          <p>レビューはまだありません</p>
        @endif
      </div>
      @if ($average)
        <a href="{{ route('product.showreviews', $product) }}" class="show_rebiews">＞＞レビューを見る</a>
      @endif
    </div>
  </div>

  <div class="wrapper700">
    @auth
    <div class="div_tar pb_10">
      <a href="{{ route('review.create', $product) }}" class="white_blue_btn a_btn_fit">この商品についてのレビューを登録</a>
    </div>
    @endauth
    <div class="div_tar">
      <a href="{{ session('product_index_url', route('product.index')) }}" class="blue_btn">商品一覧に戻る</a>
    </div>
  </div>
</div>
</x-layout>