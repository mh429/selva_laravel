<x-layout>
<header>
  <div>
    <h1>商品レビュー管理</h1>
  </div>
  <div>
    <a href="/">トップに戻る</a>     
  </div>
</header>

<div class="contents">

  <div class="wrapper550">

    @if($reviews->isEmpty())
      <div class="div_tac pb_20">
        <p>レビューはありません</p>
      </div>
    @else
      @foreach ($reviews as $review)
        <hr>
        <div class="review_product_infomations">
          <div>
            @if ($review->product->thumbnail)
              <img src="{{ asset('storage/' . $review->product->thumbnail) }}" style="width: 200px">
            @else
              <div style="width: 200px"></div>
            @endif
          </div>
          <div>
            <p class="pb_10"><span class="procudt_categories_index">{{ $review->product->category->name ?? 'カテゴリなし' }}＞{{ $review->product->subcategory->name ?? 'サブカテゴリなし' }}</span></p>
            <h2 class="mypage_review_product_title  pb_10">{{ $review->product->name }}</h2>
            <div class="review_total">
              <div>
                @for ($i = 0; $i < ceil($review->evaluation); $i++)
                  <span>★</span>
                @endfor                
              </div>
              <p>{{ ceil($review->evaluation) }}</p>
            </div>
            <p class="pb_20">
              {{ mb_strlen($review->comment) > 16
              ? mb_substr($review->comment, 0, 16) . '…'
              : $review->comment }}
            </p>
            <div>
              <a href="{{ route('mypage.review.edit', $review->id) }}" class="mypage_editdelete_btn">レビュー編集</a>
              <a href="{{ route('mypage.review.delete.confirm', $review->id) }}" class="mypage_editdelete_btn">レビュー削除</a>              
            </div>
          </div>          
        </div>
      @endforeach

      <hr>
      <div class="pager_nav_wrapper">
        {{ $reviews->links('components.pagination') }}        
      </div>
    @endif

  </div>

  <div class="div_tac">
    <a href="{{ route('mypage') }}" class="white_blue_btn">マイページに戻る</a>
  </div>
    
</div>
</x-layout>