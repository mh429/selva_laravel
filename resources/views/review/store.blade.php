<x-layout>
  <header style="width: 800px; height:100px; background-color: #FBE4D5">
    <h1>商品レビュー登録完了</h1>
    <div>
      <a href="/">トップに戻る</a>        
    </div>
  </header>

  <div>
    <p>商品レビューの登録が完了しました。</p>
  </div>

  <a href="{{ route('product.showreviews', $product) }}">商品レビュー一覧へ</a>
  <a href="{{ route('product.show', $product) }}">商品詳細に戻る</a>
</x-layout>