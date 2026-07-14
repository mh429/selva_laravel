<x-admin_layout>
<header  class="header_admin">
  <h1>会員一覧</h1>

  <div>
    <a href="{{ route('admin.index') }}">トップへ戻る</a>  
  </div>
</header>

<div class="contents">

  <div class="wrapper550">

    <a href="{{ route('admin.member.create') }}" class="blue_btn">会員登録</a>

    <div>
      <form action="" method="get">
        <table class="admin_search_table">
          <tr>
            <th>ID</th>
            <td>
              <input type="text" name="member_id" value="{{ $member_search['member_id'] ?? '' }}" class="input_300">
            </td>
          </tr>
          <tr>
            <th>性別</th>
            <td>
              @foreach (config('master.gender') as $key => $value)
                <label class="admin_search_table_gender">
                  <input type="checkbox" name="gender[]" value="{{ $key }}"  @checked(in_array($key, $member_search['gender'] ?? []))>
                    {{ $value }}
                </label>
              @endforeach            
            </td>
          </tr>
          <tr>
            <th>フリーワード</th>
            <td>
              <input type="text" name="freeword" value="{{ $member_search['freeword'] ?? '' }}" class="input_300">
            </td>
          </tr>      
        </table>      
        <div class="div_tac pb_10">
          <input type="submit" value="検索する" class="white_blue_submit">
        </div>
      </form>
    </div>

  </div>
  
  <div class="wrapper700">

    <table class="admin_member_table">
      <thead>
        <th class="th_id">
          <a href="{{ route('admin.member.index', array_merge(request()->query(), [
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
        <th class="th_member_name">氏名</th>
        <th class="th_gender">性別</th>
        <th>メールアドレス</th>
        <th class="th_created_at">
          <a href="{{ route('admin.member.index', array_merge(request()->query(), [
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
        @foreach ($members as $member)
        <tr>
          <td>{{ $member->id }}</td>
          <td><a href="{{ route('admin.member.show', $member->id) }}">{{ $member->name_sei }}　{{ $member->name_mei }}</a></td>
          <td>{{ config('master.gender')[$member->gender] }}</td>
          <td>{{ $member->email }}</td>
          <td>{{ $member->created_at->format('Y/n/j') }}</td>
          <td><a href="{{ route('admin.member.edit', $member->id) }}">編集</a></td>
          <td><a href="{{ route('admin.member.show', $member->id) }}">詳細</a></td>        
        </tr>

        @endforeach
      </tbody>
    </table>

    <div class="pager_nav_wrapper">
      {{ $members->links('components.pagination') }}
    </div>

  </div>

</div>  
</x-admin_layout>