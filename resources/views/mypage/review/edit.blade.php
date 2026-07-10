<x-layout>
  <header style="width: 800px; height:100px; background-color: #FBE4D5">
    <div>
      <h1>商品レビュー編集</h1>
    </div>
    <div>
      <a href="/">トップに戻る</a>     
    </div>
  </header>

  <div>
    <div>
      <div>
        @if ($review->product->thumbnail)
          <img src="{{ asset('storage/' . $review->product->thumbnail) }}" style="width: 200px">
        @endif
      </div>
      <div>
        <p>{{ $review->product->name }}</p>
        <p>総合評価</p>
        @for ($i = 0; $i < ceil($review->product->reviews_avg_evaluation); $i++)
          <span>★</span>
        @endfor
        <p>{{ ceil($review->product->reviews_avg_evaluation) }}</p>
      </div>
    </div>

    <hr>

    <div>
      <form action="{{ route('mypage.review.edit.confirm', $review->id) }}" method="post">
        @csrf
        <div>
          <label>
            <p>商品評価</p>
            <select name="evaluation" required>
              @for($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" @selected(old('evaluation', $input['evaluation'] ?? $review->evaluation) == $i)>
                  {{ $i }}
                </option>
              @endfor 
            </select>
          </label>      
          @error('evaluation')
            <p style="color:red">{{ $message }}</p>
          @enderror           
        </div>
        <div>
          <label>
            <p>商品コメント</p>
            <textarea name="comment" required>{{ old('comment', $input['comment'] ?? $review->comment) }}</textarea>
          </label>
          @error('comment')
            <p style="color:red">{{ $message }}</p>
          @enderror         
        </div>
        <input type="submit" value="商品レビュー編集確認">
      </form>
    </div>

    <a href="{{ route('mypage.review') }}">レビュー管理に戻る</a>
    
  </div>
</x-layout>