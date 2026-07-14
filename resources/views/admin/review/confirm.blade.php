<x-admin_layout>
<header  class="header_admin">
  <h1>{{ $mode === 'create' ? '商品レビュー登録確認' : '商品レビュー編集確認' }}</h1>

  <div>
    <a href="{{ session('admin_review_index_url', route('admin.review.index')) }}">一覧へ戻る</a>  
  </div>
</header>

<div class="contents">

  <div class="wrapper500">

    <div class="review_product_infomations">
      <div>
        @if ($product->thumbnail)
          <img src="{{ asset('storage/' . $product->thumbnail) }}" style="width: 200px">
        @endif
      </div>
      <div>
        <div class="review_total pb_10">
          <p>商品ID</p>
          <p>{{ $product->id }}</p>
        </div>
        <div class="review_total pb_30">
          <p>会員</p>
          <p>{{ $user->name_sei }} {{ $user->name_mei }}</p>
        </div>
        <p class="pb_30">{{ $product->name }}</p>
        <div class="review_total pb_20">
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
        <td>{{ $mode === 'create' ? '登録後に自動採番' : $review->id }}</td>
      </tr>
      <tr>
        <th class="confirm_table_bold">商品評価</th>
        <td>{{ $data['evaluation'] }}</td>
      </tr>
      <tr>
        <th class="confirm_table_bold">商品コメント</th>
        <td>{{ $data['comment'] }}</td>
      </tr>
    </table>

    @if ($mode === 'create')
    <form action="{{ route('admin.review.store') }}" method="POST">
      @csrf
      <div class="div_tac">
        <input type="submit" value="登録完了" class="blue_submit" onclick="this.disabled=true; this.form.submit();">
      </div>
    </form>

    @else
    <form action="{{ route('admin.review.update', $review->id) }}" method="post">
      @csrf
      @method('patch')
      <div class="div_tac">
        <input type="submit" value="編集完了" class="blue_submit" onclick="this.disabled=true; this.form.submit();">
      </div>
    </form>
    @endif

  </div>

  <div class="div_tac">
    @if ($mode === 'create')
      <a href="{{ route('admin.review.create') }}" class="white_blue_btn">前に戻る</a>
    @else
      <a href="{{ route('admin.review.edit', $review->id) }}" class="white_blue_btn">前に戻る</a>
    @endif
  </div>
</div>

</x-admin_layout>