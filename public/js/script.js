/**
 * サブカテゴリ取得
 */

const category = document.getElementById('category');
const subcategory = document.getElementById('subcategory');
 
if (category && subcategory) {
 
  async function loadSubcategories(categoryId, selectedId = '') {
    
    subcategory.innerHTML = '<option value="">---サブカテゴリ---</option>';

    if (!categoryId) {
      subcategory.style.display = 'none';
      return;
    }
 
    const response = await fetch(`/product/subcategories/${categoryId}`);
    const data = await response.json();
 
    data.forEach(item => {
      const isSelected = String(item.id) === String(selectedId);
      subcategory.insertAdjacentHTML(
        'beforeend',
        `<option value="${item.id}"${isSelected ? ' selected' : ''}>${item.name}</option>`
      );
    });

    subcategory.style.display = 'block';
  }
 
  // 確認画面から「戻る」で戻ってきた時など、大カテゴリが選択済みなら
  // サブカテゴリもAjaxで取得して選択状態を復元する
  if (category.value) {
    loadSubcategories(category.value, subcategory.dataset.selected);
  }
 
  // 大カテゴリを変更したらサブカテゴリを再取得（選択はリセット）
  category.addEventListener('change', function () {
    loadSubcategories(this.value);
  });
}


/**
 * 商品画像登録
 */

// const imageError = document.getElementById('image_error');

for (let i = 1; i <= 4; i ++) {
  
  const imageInput = document.getElementById(`image_input_${i}`);
  const imagePath = document.getElementById(`image_${i}`);
  const preview = document.getElementById(`preview${i}`);
  const deletebtn = document.getElementById(`delete${i}`);
  const imageError = document.getElementById(`image_error${i}`);

  if (imageInput && imagePath && preview) {
    // 戻ってきた時、hiddenがあればプレビュー表示    
    if (imagePath.value !== '') {

      preview.src = imagePath.dataset.url;
      preview.style.display = 'block';
      deletebtn.style.display = 'block';
    }

    // 削除ボタンが押された時
    deletebtn.addEventListener('click', function () {
      // hiddenから削除（パスと表示用URLの両方）
      imagePath.value = '';
      imagePath.dataset.url = '';

      // プレビュー非表示
      preview.src = '';
      preview.style.display = 'none';
      deletebtn.style.display = 'none';
    });


    // ファイルが選択されたらアップロードしてプレビュー表示
    imageInput.addEventListener('change', async function () {
      // inputで選択されたファイルを変数に保存
      const file = this.files[0];

      // 選択されたファイルをチェック
      if (!file) {
        return;
      }
      // 10MBまで
      if (file.size > 10 * 1024 * 1024) {
        alert('画像は10MB以下にしてください。');
        // PHPの上限が10MBなので、バリデーションエラーメッセージが表示されない
        imageError.textContent = '※商品写真は10MB以下にしてください。';
        this.value = '';
        return;
      }      
      // jpg jpeg png gifのみ
      const allowTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
      ];
      if (!allowTypes.includes(file.type)) {
        alert('jpg・jpeg・png・gifのみアップロードできます。');
        // バリデーションに飛ぶ前にreturnされるので
        imageError.textContent = '※商品写真には、以下のファイルタイプを指定してください。jpg, jpeg, png, gif';
        this.value = '';
        return;
      }

      // // コンソールに画像サイズを表示
      // console.log(file.size);
      // console.log(file.size / 1024 / 1024);

      // フォームデータ作成
      const formData = new FormData();
      // name="imageInput"、value="file"
      formData.append('imageInput', file);
      // CSRFトークン取得
      const token = document.querySelector('meta[name="csrf-token"]').content;

      // ブレードからアップロード用のルート名を取得
      const uploadUrl = document.getElementById('upload_url').value;

      // フォーム送信して返り値を受け取る
      const response = await fetch(uploadUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',   // エラーメッセージ受取り
        },
        credentials: 'same-origin',
        body: formData,
      });
      if (!response.ok) {
        // エラーメッセージをブレードに表示
        const error = await response.json();
        imageError.textContent = '※' + error.errors.imageInput[0];
        // console.log(error);
        return;
      }
      // 返り値をJSON変換して変数に保存
      const data = await response.json();

      // エラーメッセージを消去
      imageError.textContent = '';

      // hiddenへ保存（パスと表示用URLの両方）
      imagePath.value = data.path;
      imagePath.dataset.url = data.url;

      // プレビュー表示
      preview.src = data.url;
      preview.style.display = 'block';
      deletebtn.style.display = 'block';
    });
  }
}


