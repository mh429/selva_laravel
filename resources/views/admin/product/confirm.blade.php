<x-admin_layout>
<header  class="header_admin">
  <h1>{{ $mode === 'create' ? '商品登録' : '商品編集' }}</h1>

  <div>
    <a href="{{ session('admin_product_index_url', route('admin.product.index')) }}">一覧へ戻る</a>  
  </div>
</header>

<div class="contents">

  <div class="wrapper500">

    <table class="confirm_table">
      <tr>
        <th>商品ID</th>
        <td>{{ $mode === 'create' ? '登録後に自動採番' : $product->id }}</td>
      </tr>
      <tr>
        <th>会員</th>
        <td>{{ $user->name_sei }} {{ $user->name_mei }}</td>
      </tr>
      <tr>
        <th>商品名</th>
        <td>{{ $data['name'] }}</td>
      </tr>
      <tr>
        <th>商品カテゴリ</th>
        <td>{{ $category->name }}＞{{ $subcategory->name }}</td>
      </tr>
      <tr>
        <th style="vertical-align: top;">商品写真</th>
        <td>
          @for($i = 1; $i <= 4; $i++)
            <div class="image_confirm">
              <p>写真{{ $i }}</p>
              @if(!empty($data['image_'.$i]))
                <img src="{{ asset('storage/' . $data['image_'.$i]) }}" style="max-width:200px;">
              @else
                <p>選択されていません</p>
              @endif
            </div>
          @endfor
        </td>
      </tr>
      <tr>
        <th>商品説明</th>
        <td>{{ $data['product_content'] }}</td>
      </tr>
    </table>

    @if ($mode === 'create')
    <form action="{{ route('admin.product.store') }}" method="POST">
      @csrf
      <div class="div_tac">
        <input type="submit" value="登録完了" class="white_blue_submit" onclick="this.disabled=true; this.form.submit();">
      </div>
    </form>

    @else
    <form action="{{ route('admin.product.update', $product->id) }}" method="post">
      @csrf
      @method('patch')
      <div class="div_tac">
        <input type="submit" value="編集完了" class="white_blue_submit" onclick="this.disabled=true; this.form.submit();">
      </div>
    </form>
    @endif

  </div>

  <div class="div_tac">
    @if ($mode === 'create')
      <a href="{{ route('admin.product.create') }}" class="white_blue_btn">前に戻る</a>
    @else
      <a href="{{ route('admin.product.edit', $product->id) }}" class="white_blue_btn">前に戻る</a>
    @endif
  </div>
</div>

</x-admin_layout>