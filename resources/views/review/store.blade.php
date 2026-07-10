<x-layout>
<header>
  <h1>商品レビュー登録完了</h1>
  <div>
    <a href="/">トップに戻る</a>        
  </div>
</header>

<div class="contents">

  <div class="wrapper500">

  <div class="div_tac review_store_message">
    <p>商品レビューの登録が完了しました。</p>
  </div>

  <div class="div_tac pb_10">
    <a href="{{ route('product.showreviews', $product) }}" class="white_blue_btn">商品レビュー一覧へ</a>
  </div>
  <div class="div_tac">
    <a href="{{ route('product.show', $product) }}" class="blue_btn">商品詳細に戻る</a>
  </div>
  
</div>
</x-layout>