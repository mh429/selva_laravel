<x-admin_layout>
<header  class="header_admin">
  <h1>商品カテゴリ詳細</h1>

  <div>
    <a href="{{ session('admin_category_index_url', route('admin.category.index')) }}">一覧へ戻る</a>  
  </div>
</header>

<div class="contents">

  <div class="wrapper550">

    <table class="category_input_table">
      <tr>
        <th>商品大カテゴリID</th>
        <td>{{ $productCategory->id }}</td>
      </tr>
      <tr>
        <th>商品大カテゴリ</th>
        <td>{{ $productCategory->name }}</td>      
      </tr>
      <tr>
        <th style="vertical-align: top;">商品小カテゴリ</th>
        <td>
          @foreach ($productCategory->subcategories as $subcategory)        
            <p>{{ $subcategory->name }}</p>
          @endforeach
        </td>
      </tr>
    </table>

  </div>

  <div class="wrapper500">

    <div class="admin_edit_delete_btn_wrapper pb_10">
      <a href="{{ route('admin.category.edit', $productCategory->id) }}" class="white_blue_btn">編集</a>

      <form action="{{ route('admin.category.destroy', $productCategory->id) }}" method="post">
        @csrf
        @method('delete')
          <input type="submit" value="削除" class="white_blue_submit" onclick="this.disabled=true; this.form.submit();">
      </form>
    </div>

  </div>

</div>  
</x-admin_layout>