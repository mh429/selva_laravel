<x-layout>
<header>
  <div>
    <h1>商品レビュー編集</h1>
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
      <form action="{{ route('mypage.review.edit.confirm', $review->id) }}" method="post">
        @csrf

        <table class="mini_table">
          <tr>
            <th>商品評価</th>
            <td>
              <select name="evaluation" required>
                <option value="">選択してください</option>
                @for($i = 1; $i <= 5; $i++)
                  <option value="{{ $i }}" @selected(old('evaluation', $input['evaluation'] ?? $review->evaluation) == $i)>
                    {{ $i }}
                  </option>
                @endfor 
              </select>
              <div class="error_div">
                @error('evaluation')
                  <p style="color:red">{{ $message }}</p>
                @enderror           
              </div>              
            </td>
          </tr>
          <tr>
            <th>商品コメント</th>
            <td>
              <textarea name="comment" required class="text_250">{{ old('comment', $input['comment'] ?? $review->comment) }}</textarea>
              <div class="error_div">
                @error('comment')
                  <p style="color:red">{{ $message }}</p>
                @enderror                     
              </div>              
            </td>
          </tr>
        </table>

        <div class="div_tac">
          <input type="submit" value="商品レビュー編集確認" class="blue_submit">
        </div>
        
      </form>
    </div>

  </div>

  <div class="div_tac">
    <a href="{{ route('mypage.review') }}" class="white_blue_btn">レビュー管理に戻る</a>
  </div>
    
</div>
</x-layout>