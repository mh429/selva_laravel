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
    public function create(Request $request)
    {
        if ($request->filled('from')) {
            session(['product_create_from' => $request->from]);
        }

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
        $request->validate(
        [
            'imageInput' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,gif',
                'max:10240',
            ],
        ],
        [],
        [
            'imageInput' => '商品写真',
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
        $data = $request->validate(
            [
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
            ]
        );

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
        session()->forget('product'); 

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
 
        return redirect()->route('top');
    }

    // 商品一覧表示
    public function index(Request $request)
    {
        $query = Product::with(['category', 'subcategory'])
            ->withAvg('reviews', 'evaluation');

        // 大カテゴリ
        if ($request->filled('product_category_id')) {
            $query->where('product_category_id', $request->product_category_id);
        }

        // 小カテゴリ
        if ($request->filled('product_subcategory_id')) {
            $query->where('product_subcategory_id', $request->product_subcategory_id);
        }

        // フリーワード
        if ($request->filled('freeword')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->freeword . '%')
                ->orWhere('product_content', 'like', '%' . $request->freeword . '%');
            });
        }

        $products = $query->paginate(10)->withQueryString();

        // 検索条件をビューへ渡す
        $product_search = $request->only([
            'product_category_id',
            'product_subcategory_id',
            'freeword',
        ]);

        // カテゴリ一覧を取得
        $categories = ProductCategory::select('id', 'name')->get();

        session(['product_index_url' => url()->full()]);

        return view('product.index', compact('products', 'categories', 'product_search'));
    }

    // 商品詳細表示
    public function show(Product $product)
    {
        // リレーションを取得
        $product->load(['category', 'subcategory']);
        $average = $product->reviews()->avg('evaluation');

        return view('product.show', compact('product', 'average'));
    }

    // 商品ごとのレビュー表示
    public function showReviews(Product $product)
    {
        // リレーションを取得
        $product->load(['category', 'subcategory']);
        $average = $product->reviews()->avg('evaluation');

        // レビュー一覧（3件ずつ）
        $reviews = $product->reviews()
            ->with('user')
            ->latest()
            ->paginate(5);

        return view('product.showreviews', compact('product', 'average', 'reviews'));
    }
}
