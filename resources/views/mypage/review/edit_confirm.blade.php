<x-layout>
  <header style="width: 800px; height:100px; background-color: #FBE4D5">
    <div>
      <h1>商品レビュー編集確認</h1>
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
      <table>
        <tr>
          <th>
            <p>商品評価</p>
          </th>
          <td>
            <p>{{ $data['evaluation'] }}</p>
          </td>
        </tr>
        <tr>
          <th>
            <p>商品コメント</p>
          </th>
          <td>
            <p>{{ $data['comment'] }}</p>
          </td>
        </tr>
      </table>
    </div>

    <form action="{{ route('mypage.review.update', $review->id) }}" method="POST">
      @csrf
      @method('patch')
      <input type="submit" value="更新する">
    </form>

    <a href="{{ route('mypage.review.edit', $review->id) }}">前に戻る</a>
    
  </div>
</x-layout>