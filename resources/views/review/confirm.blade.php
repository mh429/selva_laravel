<x-layout>
  <header style="width: 800px; height:100px; background-color: #FBE4D5">
    <h1>商品レビュー登録確認</h1>
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

  <form action="{{ route('review.store', $product) }}" method="POST">
    @csrf
    <input type="submit" value="登録する">
  </form>

  <a href="{{ route('review.create', $product) }}">前に戻る</a>
</x-layout>