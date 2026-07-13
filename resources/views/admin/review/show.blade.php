<x-admin_layout>
  <header style="width: 800px; height:100px; background-color: #D0CECE">
    <h1>商品レビュー詳細</h1>

    <div>
      <a href="{{ session('admin_review_index_url', route('admin.review.index')) }}">一覧へ戻る</a>  
    </div>
  </header>

    <div class="review_product_infomations">
      <div>
        @if ($review->product->thumbnail)
          <img src="{{ asset('storage/' . $review->product->thumbnail) }}" style="width: 200px">
        @endif
      </div>
      <div>
        <div>
          <p>商品ID</p>
          <p>{{ $review->product->id }}</p>
        </div>
        <h2 class="pb_20">{{ $review->product->name }}</h2>
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
            <p>レビューはありません</p>
          @endif
        </div>
      </div>
    </div>

  <hr>

  <table>
    <tr>
      <th>ID</th>
      <td>{{ $review->id }}</td>
    </tr>
    <tr>
      <th>商品評価</th>
      <td>{{ $review->evaluation }}</td>      
    </tr>
    <tr>
      <th>商品コメント</th>
      <td>{{ $review->comment }}</td>
    </tr>
  </table>

  <a href="{{ route('admin.review.edit', $review->id) }}">編集</a>

  <form action="{{ route('admin.review.destroy', $review->id) }}" method="post">
    @csrf
    @method('delete')
    <input type="submit" value="削除">
  </form>

</x-admin_layout>