<x-admin_layout>
  <header style="width: 800px; height:100px; background-color: #D0CECE">
    <h1>商品詳細</h1>

    <div>
      <a href="{{ session('admin_product_index_url', route('admin.product.index')) }}">一覧へ戻る</a>  
    </div>
  </header>

  <table>
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
      <td>{{ $product->category->name }}＞{{ $product->subcategory->name }}</td>
    </tr>
    <tr>
      <th style="vertical-align: top;">商品写真</th>
      <td>
        @for($i = 1; $i <= 4; $i++)
          @php
            $image = 'image_' . $i;
          @endphp
          <p>写真{{ $i }}</p>   
          @if(!empty($product->$image))
            <img src="{{ asset('storage/' . $product->$image) }}" style="max-width:200px;">
          @else
            <p>なし</p>
          @endif
        @endfor
      </td>
    </tr>
  </table>


  <div style="width: 800px; height:100px; background-color: #D0CECE">
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


  @if(!empty($reviews))
    @foreach ($reviews as $review)
      <div>
        <div>
          <p>商品レビューID</p>
          <p>{{ $review->id }}</p>          
        </div>
        <div>
          <p>{{ $review->user->name_sei }} {{ $review->user->name_mei }}さん</p>
          <div>
            @for ($i = 0; $i < $review->evaluation; $i++)
              <span>★</span>
            @endfor
          </div>
          <p>{{ $review->evaluation }}</p>
        </div>
        <div>
          <p>商品コメント</p>
          <p>{{ $review->comment }}</p>          
        </div>
        <div>
          <a href="{{ route('admin.review.show', $review->id) }}">商品レビュー詳細</a>
        </div>
      </div>
      <hr>
    @endforeach

    {{ $reviews->links() }}
  @endif


  <a href="{{ route('admin.product.edit', $product->id) }}">編集</a>

  <form action="{{ route('admin.product.destroy', $product->id) }}" method="post">
    @csrf
    @method('delete')
    <input type="submit" value="削除">
  </form>

</x-admin_layout>