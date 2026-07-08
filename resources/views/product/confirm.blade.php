<x-layout>
  <div class="contents">

    <h1>商品登録確認画面</h1>

    <div class="wrapper500">

      <table class="confirm_table">
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
              <div class="image_confirm">
                <p>写真{{ $i }}</p>
                @if(!empty($data['image_'.$i]))
                  <img src="{{ asset('storage/' . $data['image_'.$i]) }}" style="max-width:200px;">
                @else
                  <p class="no_file">選択されていません</p>
                @endif                
              </div>
            @endfor
          </td>
        </tr>
        <tr>
          <th>商品説明</th>
          <td>{!! nl2br(e($data['product_content'])) !!}</td>
        </tr>
      </table>

      <form action="{{ route('product.store') }}" method="POST">
        @csrf
        <div class="div_tac">
          <input type="submit" value="商品を登録する" onclick="this.disabled=true; this.form.submit();">
        </div>
      </form>

    </div>

    <div class="div_tac">
      <a href="{{ route('product.create') }}" class="white_btn">前に戻る</a> 
    </div>

  </div>
</x-layout>