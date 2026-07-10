<x-layout>
<header>
  <h1>商品レビュー一覧</h1>
    <div>
      <a href="/">トップに戻る</a>        
    </div>
</header>

<div class="contents">

  <div class="wrapper550">

    <div class="review_product_infomations">
      <div>
        @if ($product->thumbnail)
          <img src="{{ asset('storage/' . $product->thumbnail) }}" style="width: 200px">
        @endif
      </div>
      <div>
        <h2 class="pb_20">{{ $product->name }}</h2>
        <div class="review_total">
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

    @foreach ($reviews as $review)
    <hr>
      <div class="review_wrapper">
        <div class="review_flex pb_10">
          <p class="review_left">{{ $review->user->name_sei }} {{ $review->user->name_mei }}さん</p>
          <div class="stars">
            @for ($i = 0; $i < $review->evaluation; $i++)
              <span>★</span>
            @endfor
          </div>
          <p>{{ $review->evaluation }}</p>
        </div>
        <div class="review_flex">
          <p class="review_left">商品コメント</p>
          <p class="review_comment">{!! nl2br(e($review->comment)) !!}</p>
        </div>
      </div>
    @endforeach

    <div>
      <hr>
      <div class="pager_nav_wrapper">
        {{ $reviews->links('components.pagination') }}
      </div>
    </div>

  </div>

  <div class="div_tac">
    <a href="{{ route('product.show', $product) }}" class="blue_btn">商品詳細に戻る</a>
  </div>
  
</div>
</x-layout>