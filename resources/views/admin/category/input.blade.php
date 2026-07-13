<x-admin_layout>

  <header style="width: 800px; height:100px; background-color: #D0CECE">
    <h1>{{ $mode === 'create' ? '商品カテゴリ登録' : '商品カテゴリ編集' }}</h1>

    <div>
      <a href="{{ session('admin_category_index_url', route('admin.category.index')) }}">一覧へ戻る</a>  
    </div>
  </header>

  <div class="contents">

    <div class="wrapper500">
    
      @if ($mode === 'create')
        <form action="{{ route('admin.category.create.confirm') }}" method="post">
      @else
        <form action="{{ route('admin.category.edit.confirm', $category['id']) }}" method="post">
      @endif

        @csrf

        <div class="div_form_inputs">

          <table>
            <tr>
              <th>商品大カテゴリID</th>
              <td>
                @if ($mode === 'create')
                  <p>登録後に自動採番</p>
                @else
                  <p>{{ $category['id'] }}</p>
                @endif
              </td>
            </tr>
            <tr>
              <th>商品大カテゴリ</th>
              <td>
                <input type="text" name="name" value="{{ old('name', $category['name'] ?? '') }}" required class="input_250">
                <div class="error_wrapper">
                  @error('name')
                    <p style="color:red">※{{ $message }}</p>
                  @enderror
                </div>                               
              </td>
            </tr>
            <tr>
              <th style="vertical-align: top;">商品小カテゴリ</th>
              <td>
                @for ($i = 1; $i <= 10; $i++)
                  <input type="text" name="subcategory{{ $i }}" value="{{ old('subcategory'.$i, $category['subcategory'.$i] ?? '') }}" class="input_250">
                  <div class="error_wrapper">
                    @error('subcategory'.$i)
                      <p style="color:red">※{{ $message }}</p>
                    @enderror
                  </div>   
                @endfor
                @error('subcategory')
                  <p style="color:red">※{{ $message }}</p>
                @enderror
              </td>
            </tr>
          </table>

        </div>

        <div class="div_tac">
          <input type="submit" value="確認画面へ">
        </div>

      </form>
    </div>

  </div>

</x-admin_layout>