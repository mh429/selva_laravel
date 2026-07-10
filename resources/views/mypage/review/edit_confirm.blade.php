<x-layout>
<header>
  <div>
    <h1>商品レビュー編集確認</h1>
  </div>
  <div>
    <a href="/">トップに戻る</a>     
  </div>
</header>

<div class="contents">

  <div class="wrapper550">
    
    <div class="review_product_infomations">
      <div>
        @if ($review->product->thumbnail)
          <img src="{{ asset('storage/' . $review->product->thumbnail) }}" style="width: 200px">
        @endif
      </div>
      <div>
        <h2 class="pb_20">{{ $review->product->name }}</h2>
        <div class="review_total">
          <p>総合評価</p>
          @if ($review->product->reviews_avg_evaluation)
            <div>
              @for ($i = 0; $i < ceil($review->product->reviews_avg_evaluation); $i++)
                <span>★</span>
              @endfor
            </div>
            <p>{{ ceil($review->product->reviews_avg_evaluation) }}</p>       
          @else
            <p>レビューはまだありません</p>
          @endif
        </div>
      </div>
    </div>

    <hr>

    <div>
      <table class="mini_table">
        <tr>
          <th>
            <p class="bold">商品評価</p>
          </th>
          <td>
            <p>{{ $data['evaluation'] }}</p>
          </td>
        </tr>
        <tr>
          <th>
            <p class="bold">商品コメント</p>
          </th>
          <td>
            <p>{!! nl2br(e($data['comment'])) !!}</p>
          </td>
        </tr>
      </table>
    </div>

    <form action="{{ route('mypage.review.update', $review->id) }}" method="POST">
      @csrf
      @method('patch')
      <div class="div_tac">
        <input type="submit" value="更新する" class="blue_submit" onclick="this.disabled=true; this.form.submit();">
      </div>
    </form>

  </div>

  <div class="div_tac">
    <a href="{{ route('mypage.review.edit', $review->id) }}" class="white_blue_btn">前に戻る</a>
  </div>
  
</div>
</x-layout>