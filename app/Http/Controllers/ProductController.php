<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // 商品登録画面を表示
    public function create()
    {
        $product = session('product');
        $categories = ProductCategory::select('id', 'name')->get();

        return view('product.create', compact('product', 'categories'));
    }

    // サブカテゴリ取得（Ajax）
    public function getSubcategories(ProductCategory $category)
    {
        return response()->json(
            $category->subcategories()
                ->select('id', 'name')
                ->get()
        );
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

    // 登録内容確認画面
    public function confirm(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'product_category_id' => ['required', 'integer', 'exists:product_categories,id'],
            'product_subcategory_id' => ['required', 'integer', 'exists:product_subcategories,id'],
            'image_1' => ['nullable', 'string'],
            'image_2' => ['nullable', 'string'],
            'image_3' => ['nullable', 'string'],
            'image_4' => ['nullable', 'string'],
            'product_content' => ['required', 'string', 'max:500'],
        ]);

        session()->put('product', $data);

        $category = ProductCategory::find($data['product_category_id']);
        $subcategory = ProductSubcategory::find($data['product_subcategory_id']);

        return view('product.confirm', compact('data','category','subcategory'));
    }

    // DB登録
    public function store(Request $request)
    {
        $data = session('product');
        if (!$data) {
            return redirect()->route('product.create');
        }
 
        Product::create([
            'member_id' => Auth::id(),
            'name' => $data['name'],
            'product_category_id' => $data['product_category_id'],
            'product_subcategory_id' => $data['product_subcategory_id'],
            'image_1' => $data['image_1'] ?? null,
            'image_2' => $data['image_2'] ?? null,
            'image_3' => $data['image_3'] ?? null,
            'image_4' => $data['image_4'] ?? null,
            'product_content' => $data['product_content'],
        ]);
 
        session()->forget('product');
 
        return redirect()->route('top');
    }
}
