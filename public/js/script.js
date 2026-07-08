/**
 * サブカテゴリ取得
 */

const category = document.getElementById('category');
const subcategory = document.getElementById('subcategory');
 
if (category && subcategory) {
 
  async function loadSubcategories(categoryId, selectedId = '') {
    
    subcategory.innerHTML = '<option value="">---商品小カテゴリ---</option>';

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

// const category = document.getElementById('category');
// const subcategory = document.getElementById('subcategory');
 
// if (category && subcategory) {
 
//   async function loadSubcategories(categoryId, selectedId = '') {
//     subcategory.innerHTML = '<option value="">選択してください</option>';
 
//     if (!categoryId) {
//       return;
//     }
 
//     const response = await fetch(`/product/subcategories/${categoryId}`);
//     const data = await response.json();
 
//     data.forEach(item => {
//       const isSelected = String(item.id) === String(selectedId);
//       subcategory.insertAdjacentHTML(
//         'beforeend',
//         `<option value="${item.id}"${isSelected ? ' selected' : ''}>${item.name}</option>`
//       );
//     });
//   }
 
//   // 確認画面から「戻る」で戻ってきた時など、大カテゴリが選択済みなら
//   // サブカテゴリもAjaxで取得して選択状態を復元する
//   if (category.value) {
//     loadSubcategories(category.value, subcategory.dataset.selected);
//   }
 
//   // 大カテゴリを変更したらサブカテゴリを再取得（選択はリセット）
//   category.addEventListener('change', function () {
//     loadSubcategories(this.value);
//   });
// }


/**
 * 商品画像登録
 */

for (let i = 1; i <= 4; i ++) {
  const imageInput = document.getElementById(`image_input_${i}`);
  const imagePath = document.getElementById(`image_${i}`);
  const preview = document.getElementById(`preview${i}`);

  if (imageInput && imagePath && preview) {
    // 戻ってきた時、hiddenがあればプレビュー表示    
    if (imagePath.value !== '') {

      preview.src = imagePath.dataset.url;
      preview.style.display = 'block';
    }

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
        this.value = '';
        return;
      }

      // フォームデータ作成
      const formData = new FormData();
      // name="imageInput"、value="file"
      formData.append('imageInput', file);
      // CSRFトークン取得
      const token = document.querySelector('meta[name="csrf-token"]').content;

      // フォーム送信して返り値を受け取る
      const response = await fetch('/product/upload', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
        },
        body: formData,
      });
      if (!response.ok) {
        alert('画像のアップロードに失敗しました。');
        return;
      }
      // 返り値をJSON変換して変数に保存
      const data = await response.json();

      // hiddenへ保存（パスと表示用URLの両方）
      imagePath.value = data.path;
      imagePath.dataset.url = data.url;

      // プレビュー表示
      preview.src = data.url;
      preview.style.display = 'block';
    });
  }
}


