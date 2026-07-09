<x-layout>
<header style="width: 800px; height:100px; background-color: #FBE4D5">
  <h1>商品レビュー登録確認</h1>
  <div>
    <a href="/">トップに戻る</a>        
  </div>
</header>

<div class="contents">

  <div class="wrapper550">

    <div class="review_product_infomations">
      <div>
        @if ($product->thumbnail)
          <img src="{{ asset('storage/' . $product->thumbnail) }}" style="width: 200px">
        @endif
      </div>
      <div>
        <h2 class="pb_20">{{ $product->name }}</h2>
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

    <form action="{{ route('review.store', $product) }}" method="POST">
      @csrf
      <div class="div_tac">
        <input type="submit" value="登録する" onclick="this.disabled=true; this.form.submit();" class="blue_submit">
      </div>
    </form>

  </div>

  <div class="div_tac">
    <a href="{{ route('review.create', $product) }}" class="white_blue_btn">前に戻る</a>
  </div>
  
</div>
</x-layout>