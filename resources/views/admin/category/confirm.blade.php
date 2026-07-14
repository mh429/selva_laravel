<x-admin_layout>
<header  class="header_admin">
  <h1>{{ $mode === 'create' ? '商品カテゴリ登録確認' : '商品カテゴリ編集確認' }}</h1>

  <div>
    <a href="{{ session('admin_category_index_url', route('admin.category.index')) }}">一覧へ戻る</a>  
  </div>
</header>

<div class="contents">

  <div class="wrapper500">

    <table class="category_input_table">
      <tr>
        <th>商品大カテゴリID</th>
        <td>{{ $mode === 'create' ? '登録後に自動採番' : $productCategory->id }}</td>
      </tr>
      <tr>
        <th>商品大カテゴリ</th>
        <td>{{ $data['name'] }}</td>
      </tr>
      <tr>
        <th>商品小カテゴリ</th>
        <td>
          @for ($i = 1; $i <= 10; $i++)
            @if ($data['subcategory'.$i])
              <p class="pb_10">{{ $data['subcategory'.$i] }}<p>
            @endif
          @endfor
        </td>
      </tr>
    </table>

    @if ($mode === 'create')
    <form action="{{ route('admin.category.store') }}" method="POST">
      @csrf
      <div class="div_tac">
        <input type="submit" value="登録完了" class="white_blue_submit" onclick="this.disabled=true; this.form.submit();">
      </div>
    </form>

    @else
    <form action="{{ route('admin.category.update', $productCategory->id) }}" method="post">
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
      <a href="{{ route('admin.category.create') }}" class="white_blue_btn">前に戻る</a>
    @else
      <a href="{{ route('admin.category.edit', $productCategory->id) }}" class="white_blue_btn">前に戻る</a>
    @endif
  </div>
</div>

</x-admin_layout>