<x-admin_layout>
  <header style="width: 800px; height:100px; background-color: #D0CECE">
    <h1>商品カテゴリ詳細</h1>

    <div>
      <a href="{{ session('admin_category_index_url', route('admin.category.index')) }}">一覧へ戻る</a>  
    </div>
  </header>

  <table>
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

  <a href="{{ route('admin.category.edit', $productCategory->id) }}">編集</a>

  <form action="{{ route('admin.category.destroy', $productCategory->id) }}" method="post">
    @csrf
    @method('delete')
    <input type="submit" value="削除">
  </form>

</x-admin_layout>