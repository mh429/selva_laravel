<x-admin_layout>
<header  class="header_admin">
  <h1>商品詳細</h1>

  <div>
    <a href="{{ session('admin_product_index_url', route('admin.product.index')) }}">一覧へ戻る</a>  
  </div>
</header>

<div class="contents">
  <div class="wrapper550">

    <table class="confirm_table">
      <tr>
        <th>商品ID</th>
        <td>{{ $product->id }}</td>
      </tr>
      <tr>
        <th>会員</th>
        <td>{{ $product->user->name_sei }} {{ $product->user->name_mei }}</td>      
      </tr>
      <tr>
        <th>商品名</th>
        <td>{{ $product->name }}</td>
      </tr>
      <tr>
        <th>商品カテゴリ</th>
        <td>{{ $product->category->name ?? 'カテゴリなし' }}＞{{ $product->subcategory->name ?? 'サブカテゴリなし' }}</td>
      </tr>
      <tr>
        <th style="vertical-align: top;">商品写真</th>
        <td>
          @for($i = 1; $i <= 4; $i++)
            @php
              $image = 'image_' . $i;
            @endphp
            <div class="image_confirm">
              <p>写真{{ $i }}</p>   
              @if(!empty($product->$image))
                <img src="{{ asset('storage/' . $product->$image) }}" style="max-width:200px;">
              @else
                <p>なし</p>
              @endif
            </div>
          @endfor
        </td>
      </tr>
      <tr>
        <th>商品説明</th>
        <td>{{ $product->product_content }}</td>
      </tr>
    </table>
  </div>
</div>


<div class="admin_product_detail_average">
  <div class="wrapper550">
    <div class="review_total">
      <p class="bold">総合評価</p>
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


@if(!empty($reviews))
  <div class="wrapper550 pb_40">
    @foreach ($reviews as $review)
      <div class="review_wrapper">
        <div class="review_flex pb_10">
          <p class="review_left">商品レビューID</p>
          <p>{{ $review->id }}</p>          
        </div>
        <div class="review_flex pb_10">
          <p class="review_left">
            <a href="{{ route('admin.member.show', $review->user->id) }}">{{ $review->user->name_sei }} {{ $review->user->name_mei }}さん</a>
          </p>
          <div>
            @for ($i = 0; $i < $review->evaluation; $i++)
              <span>★</span>
            @endfor
          </div>
          <p>{{ $review->evaluation }}</p>
        </div>
        <div class="review_flex">
          <p class="review_left">商品コメント</p>
          <p class="review_comment">{!! nl2br(e($review->comment)) !!}</p>          
        </div>
        <div class="div_tar">
          <a href="{{ route('admin.review.show', $review->id) }}" class="like_header_a">商品レビュー詳細</a>
        </div>
      </div>
      <hr>
    @endforeach

    <div class="pager_nav_wrapper">
      {{ $reviews->links('components.pagination') }}
    </div>

  </div>
@endif

<div class="wrapper550">
  <div class="admin_edit_delete_btn_wrapper pb_40">
    <a href="{{ route('admin.product.edit', $product->id) }}" class="white_blue_btn">編集</a>

    <form action="{{ route('admin.product.destroy', $product->id) }}" method="post">
      @csrf
      @method('delete')
      <input type="submit" value="削除" class="white_blue_submit" onclick="this.disabled=true; this.form.submit();">
    </form>
  </div>
</div>


</x-admin_layout>