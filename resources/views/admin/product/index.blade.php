<x-admin_layout>
<header  class="header_admin">
  <h1>商品一覧</h1>

  <div>
    <a href="{{ route('admin.index') }}">トップへ戻る</a>  
  </div>
</header>

<div class="contents">

  <div class="wrapper550">

    <a href="{{ route('admin.product.create') }}" class="blue_btn">新規登録</a>

    <div>
      <form action="" method="get">
        <table class="admin_search_table">
          <tr>
            <th>ID</th>
            <td>
              <input type="text" name="product_id" value="{{ $product_search['product_id'] ?? '' }}" class="input_300">
            </td>
          </tr>
          <tr>
            <th>フリーワード</th>
            <td>
              <input type="text" name="freeword" value="{{ $product_search['freeword'] ?? '' }}" class="input_300">
            </td>
          </tr>      
        </table>      
        <div class="div_tac pb_10">
          <input type="submit" value="検索する" class="white_blue_submit">
        </div>
      </form>
    </div>

  </div>
  
  <div class="wrapper550">

    <table class="admin_member_table">
      <thead>
        <th class="th_id">
          <a href="{{ route('admin.product.index', array_merge(request()->query(), [
              'sort' => 'id',
              'order' => request('sort') === 'id' && request('order') === 'asc'
                  ? 'desc'
                  : 'asc',
          ])) }}">
              ID
              @if(request('sort', 'id') === 'id')
                  {{ request('order', 'desc') === 'asc' ? '▲' : '▼' }}
              @endif
          </a>
        </th>
        <th>商品名</th>
        <th class="th_created_at">
          <a href="{{ route('admin.product.index', array_merge(request()->query(), [
              'sort' => 'created_at',
              'order' => request('sort') === 'created_at' && request('order') === 'asc'
                  ? 'desc'
                  : 'asc',
          ])) }}">
              登録日時
              @if(request('sort') === 'created_at')
                  {{ request('order') === 'asc' ? '▲' : '▼' }}
              @endif
          </a>        
        </th>
        <th class="th_edit_detail">編集</th>
        <th class="th_edit_detail">詳細</th>
      </thead>
      <tbody>
        @foreach ($products as $product)
        <tr>
          <td>{{ $product->id }}</td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->created_at->format('Y/n/j') }}</td>
          <td><a href="{{ route('admin.product.edit', $product->id) }}">編集</a></td>
          <td><a href="{{ route('admin.product.show', $product->id) }}">詳細</a></td>        
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="pager_nav_wrapper">
      {{ $products->links('components.pagination') }}
    </div>
  </div>

</div>  
</x-admin_layout>