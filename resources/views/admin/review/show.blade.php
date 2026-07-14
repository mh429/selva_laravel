<x-admin_layout>
<header  class="header_admin">
  <h1>商品レビュー詳細</h1>

  <div>
    <a href="{{ session('admin_review_index_url', route('admin.review.index')) }}">一覧へ戻る</a>  
  </div>
</header>

<div class="contents">

  <div class="wrapper500">

    <div class="review_product_infomations">
      <div>
        @if ($review->product->thumbnail)
          <img src="{{ asset('storage/' . $review->product->thumbnail) }}" style="width: 200px">
        @endif
      </div>
      <div>
        <div class="review_total pb_20">
          <p>商品ID</p>
          <p>{{ $review->product->id }}</p>
        </div>
        <p class="pb_20">{{ $review->product->name }}</p>
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

    <table class="confirm_table">
      <tr>
        <th class="confirm_table_bold">ID</th>
        <td>{{ $review->id }}</td>
      </tr>
      <tr>
        <th class="confirm_table_bold">商品評価</th>
        <td>{{ $review->evaluation }}</td>      
      </tr>
      <tr>
        <th class="confirm_table_bold">商品コメント</th>
        <td>{{ $review->comment }}</td>
      </tr>
    </table>

  </div>  

  <div class="wrapper550">
    <div class="admin_edit_delete_btn_wrapper">
      <a href="{{ route('admin.review.edit', $review->id) }}" class="white_blue_btn">編集</a>

      <form action="{{ route('admin.review.destroy', $review->id) }}" method="post">
        @csrf
        @method('delete')
        <input type="submit" value="削除" class="white_blue_submit" onclick="this.disabled=true; this.form.submit();">
      </form>
    </div>
  </div>

</div>
</x-admin_layout>