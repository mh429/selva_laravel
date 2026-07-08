<x-layout>
  <header style="width: 800px; height:100px; background-color: #FBE4D5">
    <h1>商品レビュー一覧</h1>
    @auth
      <div>
        <a href="/">トップに戻る</a>        
      </div>
    @endauth
  </header>

  <div>
    <div>
      @if ($product->thumbnail)
        <img src="{{ asset('storage/' . $product->thumbnail) }}" style="width: 200px">
      @endif
    </div>
    <div>
      <h2>{{ $product->name }}</h2>
      <div>
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
    </div>
  </div>

  <hr>

  @foreach ($reviews as $review)
    <div>
      <div>
        <p>{{ $review->user->name_sei }} {{ $review->user->name_mei }}さん</p>
        <div>
          @for ($i = 0; $i < $review->evaluation; $i++)
            <span>★</span>
          @endfor
        </div>
        <p>{{ $review->evaluation }}</p>
      </div>
        <p>商品コメント</p>
        <p>{{ $review->comment }}</p>
    </div>
    <hr>
  @endforeach

  {{ $reviews->links() }}

  <a href="{{ route('product.show', $product) }}">商品詳細に戻る</a>
</x-layout>