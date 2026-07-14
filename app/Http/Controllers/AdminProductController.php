<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // ID
        if ($request->filled('product_id')) {
            $query->where('id', $request->product_id);
        }

        // フリーワード
        if ($request->filled('freeword')) {
            $freeword = $request->freeword;
            $query->where(function ($q) use ($freeword) {
                // カテゴリ名
                $q->where('name', 'like', "%{$freeword}%")
                ->orWhere('product_content', 'like', "%{$freeword}%");
            });
        }

        // ソート対象
        $sort = $request->input('sort', 'id');
        // 昇順・降順
        $order = $request->input('order', 'desc');

        // ソート可能なカラムを限定
        if (!in_array($sort, ['id', 'created_at'])) {
            $sort = 'id';
        }
        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }

        $query->orderBy($sort, $order);

        $products = $query->paginate(10)->withQueryString();


        // 検索条件をビューへ渡す
        $product_search = $request->only([
            'product_id',
            'freeword',
        ]);

        session(['admin_product_index_url' => url()->full()]);

        return view('admin.product.index', compact('products', 'product_search'));
    }

    public function create()
    {
        $product = session('admin.product.create');
        $users = User::select('id', 'name_sei', 'name_mei')->get();
        $categories = ProductCategory::select('id', 'name')->get();
        $mode = 'create';

        return view('admin.product.input', compact('product', 'mode', 'users', 'categories'));
    }

    public function createConfirm(Request $request)
    {
        $data = $request->validate([
            'member_id' => ['required', 'integer', 'exists:members,id'],
            'name' => ['required', 'string', 'max:100'],
            'product_category_id' => ['required', 'integer', 'exists:product_categories,id'],
            'product_subcategory_id' => ['required', 'integer', 'exists:product_subcategories,id'],
            'image_1' => ['nullable', 'string'],
            'image_2' => ['nullable', 'string'],
            'image_3' => ['nullable', 'string'],
            'image_4' => ['nullable', 'string'],
            'product_content' => ['required', 'string', 'max:500'],
        ],
        [],
        [
            'name' => '商品名',
            'member_id' => '会員',
        ]);

        session()->put('admin.product.create', $data);
        $mode = 'create';

        $user = User::find($data['member_id']);
        $category = ProductCategory::find($data['product_category_id']);
        $subcategory = ProductSubcategory::find($data['product_subcategory_id']);

        return view('admin.product.confirm', compact('data', 'mode', 'user', 'category', 'subcategory'));
    }

    public function store()
    {
        $data = session('admin.product.create');
        if (!$data) {
            return redirect()->route('admin.product.create');
        }
        session()->forget('admin.product.create');

        // カテゴリ登録
        Product::create($data);

        return redirect(session('admin_product_index_url', route('admin.product.index')));
    }

    public function show(Product $product)
    {
        // リレーションを取得
        $product->load(['category', 'subcategory', 'user']);
        $average = $product->reviews()->avg('evaluation');

        // レビュー一覧（3件ずつ）
        $reviews = $product->reviews()
            ->with('user')
            ->latest()
            ->paginate(3);

        return view('admin.product.show', compact('product', 'average', 'reviews'));
    }

    public function edit(Product $productModel)
    {
        $product = session("admin.product.edit.{$productModel->id}");

        if (!$product) {
            // 商品情報をDBから取得
            // ビューで使いやすいように配列にする
            $product = $productModel->toArray();
        } else {
            // セッションから取得した場合IDがないのでモデルから取得
            $product['id'] = $productModel->id;
        }

        $users = User::select('id', 'name_sei', 'name_mei')->get();
        $categories = ProductCategory::select('id', 'name')->get();
        $mode = 'edit';

        return view('admin.product.input', compact('product', 'mode', 'users', 'categories'));
    }

    public function editConfirm(Request $request, Product $product)
    {
        $data = $request->validate([
            'member_id' => ['required', 'integer', 'exists:members,id'],
            'name' => ['required', 'string', 'max:100'],
            'product_category_id' => ['required', 'integer', 'exists:product_categories,id'],
            'product_subcategory_id' => ['required', 'integer', 'exists:product_subcategories,id'],
            'image_1' => ['nullable', 'string'],
            'image_2' => ['nullable', 'string'],
            'image_3' => ['nullable', 'string'],
            'image_4' => ['nullable', 'string'],
            'product_content' => ['required', 'string', 'max:500'],
        ],
        [],
        [
            'name' => '商品名',
            'member_id' => '会員',
        ]);

        session()->put("admin.product.edit.{$product->id}", $data);
        $mode = 'edit';

        $user = User::find($data['member_id']);
        $category = ProductCategory::find($data['product_category_id']);
        $subcategory = ProductSubcategory::find($data['product_subcategory_id']);

        return view('admin.product.confirm', compact('data', 'mode', 'user', 'category', 'subcategory', 'product'));
    }

    public function update(Product $product)
    {
        $data = session("admin.product.edit.{$product->id}", []);
        if (!$data) {
            return redirect()->route('admin.index');
        }
        session()->forget("admin.category.edit.{$product->id}");

        $product->update($data);
        
        return redirect(session('admin_product_index_url', route('admin.product.index')));
    }

    public function destroy(Product $product)
    {
        // レビューをソフトデリート
        $product->reviews()->delete();
        // 商品をソフトデリート
        $product->delete();

        return redirect(session('admin_product_index_url', route('admin.product.index')));
    }

    // 画像アップロード
    public function upload(Request $request)
    {
        $request->validate([
            'imageInput' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,gif',
                'max:10240',
            ],
        ]);

        // ファイルを保存してパスを取得
        $path = $request->file('imageInput')->store('products', 'public');

        return response()->json([
            'path' => $path,
            'url' => asset('storage/' . $path),
        ]);
    }
}
