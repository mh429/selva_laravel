<x-layout>
  <header style="width: 800px; height:100px; background-color: #FBE4D5">
    <h1>商品レビュー登録</h1>
    <div>
      <a href="/">トップに戻る</a>        
    </div>
  </header>

  <div>
    <div>
      @php
        $image = null;
        foreach (['image_1', 'image_2', 'image_3', 'image_4'] as $column) {
            if (!empty($product->$column)) {
                $image = $product->$column;
                break;
            }
        }
      @endphp
      @if ($image)
        <img src="{{ asset('storage/' . $image) }}" style="width: 200px">
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

  <div>
    <form action="{{ route('review.confirm', $product) }}" method="post">
      @csrf
      <div>
        <label>
          <p>商品評価</p>
          <select name="evaluation" required>
            <option value="">選択してください</option>
            @for($i = 1; $i <= 5; $i++)
              <option value="{{ $i }}" @selected(old('evaluation', $review['evaluation'] ?? '') == $i)>
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
          <textarea name="comment" required>{{ old('comment', $review['comment'] ?? '') }}</textarea>
        </label>
        @error('comment')
          <p style="color:red">{{ $message }}</p>
        @enderror         
      </div>
      <input type="submit" value="商品レビュー登録確認">
    </form>
  </div>

  <a href="{{ route('product.show', $product) }}">商品詳細に戻る</a>
</x-layout>