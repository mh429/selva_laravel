<x-layout>

  <h1>商品登録確認画面</h1>

  <table>
    <tr>
      <th>商品名</th>
      <td>{{ $data['name'] }}</td>
    </tr>
    <tr>
      <th>商品カテゴリ</th>
      <td>{{ $category->name }}＞{{ $subcategory->name }}</td>
    </tr>
    <tr>
      <th>商品写真</th>
      <td>
        @for($i = 1; $i <= 4; $i++)
          @if(!empty($data['image_'.$i]))
            <p>写真{{ $i }}</p>        
            <img src="{{ asset('storage/' . $data['image_'.$i]) }}" style="max-width:200px;">
          @endif
        @endfor
      </td>
    </tr>
    <tr>
      <th>商品説明</th>
      <td>{{ $data['product_content'] }}</td>
    </tr>
  </table>

  <form action="{{ route('product.store') }}" method="POST">
    @csrf
    <input type="submit" value="商品を登録する">
  </form>

  <a href="{{ route('product.create') }}">前に戻る</a>
</x-layout>