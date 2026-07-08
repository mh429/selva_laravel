<x-layout>
  <header style="width: 800px; height:100px; background-color: #FBE4D5">
    <h1>商品詳細</h1>
    <div>
      <a href="/">トップに戻る</a>        
    </div>
  </header>

  <div>
    <div>
      <p>{{ $product->category->name }}>{{ $product->subcategory->name }}</p>
    </div>
    <div>
      <h2>{{ $product->name }}</h2>
      <p>更新日時：{{ $product->updated_at->format('Ymd') }}</p>
    </div>
    <div>
      @if (!empty($product->images))
        @foreach ($product->images as $image)
          <img src="{{ asset('storage/' . $image) }}" style="width: 200px">
        @endforeach
      @endif
    </div>
    <div>
      <p>◾商品説明</p>
      <p>{{ $product->product_content }}</p>
    </div>
    <div>
      <p>◾商品レビュー</p>
      <p>総合評価</p>
      @if ($average)
        <div>
          @for ($i = 0; $i < ceil($average); $i++)
            <span>★</span>
          @endfor
        </div>
        <p>{{ ceil($average) }}</p>
        <a href="{{ route('product.showreviews', $product) }}">＞＞レビューを見る</a>
      @else
        <p>レビューはまだありません</p>
      @endif
    </div>
  </div>

  @auth
    <a href="{{ route('review.create', $product) }}">この商品についてのレビューを登録</a>
  @endauth
  <a href="{{ session('product_index_url', route('product.index')) }}">商品一覧に戻る</a>
</x-layout>