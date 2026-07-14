<x-admin_layout>
<header  class="header_admin">
  <h1>商品カテゴリ一覧</h1>

  <div>
    <a href="{{ route('admin.index') }}">トップへ戻る</a>  
  </div>
</header>

<div class="contents">

  <div class="wrapper550">

    <a href="{{ route('admin.category.create') }}" class="blue_btn">商品カテゴリ登録</a>

    <div>
      <form action="" method="get">
        <table class="admin_search_table">
          <tr>
            <th>ID</th>
            <td>
              <input type="text" name="category_id" value="{{ $category_search['category_id'] ?? '' }}" class="input_300">
            </td>
          </tr>
          <tr>
            <th>フリーワード</th>
            <td>
              <input type="text" name="freeword" value="{{ $category_search['freeword'] ?? '' }}" class="input_300">
            </td>
          </tr>      
        </table>      
        <div class="div_tac pb_10">
          <input type="submit" value="検索する" class="white_blue_submit">
        </div>
      </form>
    </div>

  </div>
  
  <div class="wrapper500">

    <table class="admin_member_table">
      <thead>
        <th class="th_id">
          <a href="{{ route('admin.category.index', array_merge(request()->query(), [
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
        <th>商品大カテゴリ</th>
        <th class="th_created_at">
          <a href="{{ route('admin.category.index', array_merge(request()->query(), [
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
        @foreach ($categories as $category)
        <tr>
          <td>{{ $category->id }}</td>
          <td><a href="{{ route('admin.category.show', $category->id) }}">{{ $category->name }}</a></td>
          <td>{{ $category->created_at->format('Y/n/j') }}</td>
          <td><a href="{{ route('admin.category.edit', $category->id) }}">編集</a></td>
          <td><a href="{{ route('admin.category.show', $category->id) }}">詳細</a></td>        
        </tr>

        @endforeach
      </tbody>
    </table>

    <div class="pager_nav_wrapper">
      {{ $categories->links('components.pagination') }}
    </div>

  </div>

</div>  
</x-admin_layout>