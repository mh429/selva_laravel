<x-layout>
  <header style="width: 800px; height:100px; background-color: #FBE4D5">
    <div>
      <h1>商品レビュー管理</h1>
    </div>
    <div>
      <a href="/">トップに戻る</a>     
    </div>
  </header>

  <div>

    @if(!$reviews)
      <p>レビューはありません</p>
    @else
      @foreach ($reviews as $review)
        <hr>
        <div>
          <div>
            @if ($review->product->thumbnail)
              <img src="{{ asset('storage/' . $review->product->thumbnail) }}" style="width: 200px">
            @endif
          </div>
          <div>
            <p>{{ $review->product->category->name }}＞{{ $review->product->subcategory->name }}</p>
            <p>{{ $review->product->name }}</p>
            <div>
              @for ($i = 0; $i < ceil($review->evaluation); $i++)
                <span>★</span>
              @endfor
            </div>
            <p>{{ ceil($review->evaluation) }}</p>
            <p>{{ $review->comment }}</p>
            <a href="{{ route('mypage.review.edit', $review->id) }}">レビュー編集</a>
            <a href="{{ route('mypage.review.delete.confirm', $review->id) }}">削除する</a>
          </div>          
        </div>
      @endforeach
      <hr>
      {{ $reviews->links() }}
    @endif

    <a href="{{ route('mypage') }}">マイページに戻る</a>
    
  </div>
</x-layout>