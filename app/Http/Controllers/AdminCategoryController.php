<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductCategory::query();

        // ID
        if ($request->filled('category_id')) {
            $query->where('id', $request->category_id);
        }

        // フリーワード
        if ($request->filled('freeword')) {
            $freeword = $request->freeword;
            $query->where(function ($q) use ($freeword) {
                // カテゴリ名
                $q->where('name', 'like', "%{$freeword}%")

                // サブカテゴリ名
                ->orWhereHas('subcategories', function ($subQuery) use ($freeword) {
                    $subQuery->where('name', 'like', "%{$freeword}%");
                });
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

        $categories = $query->paginate(10)->withQueryString();


        // 検索条件をビューへ渡す
        $category_search = $request->only([
            'category_id',
            'freeword',
        ]);

        session(['admin_category_index_url' => url()->full()]);

        return view('admin.category.index', compact('categories', 'category_search'));
    }

    public function create()
    {
        $category = session('admin.category.create');
        $mode = 'create';

        return view('admin.category.input', compact('category', 'mode'));
    }

    public function createConfirm(Request $request)
    {
        // バリデーション
        $rules = ['name' => ['required', 'string', 'max:20'],];
        for ($i = 1; $i <= 10; $i++) {
            $rules["subcategory{$i}"] = ['nullable', 'string', 'max:20'];
        }
        // バリデーションメッセージ用
        $attributes = [
            'name' => '商品大カテゴリ',
        ];
        for ($i = 1; $i <= 10; $i++) {
            $attributes["subcategory{$i}"] = '商品小カテゴリ';
        }
        // バリデーション実行
        $data = $request->validate($rules, [], $attributes);

        // サブカテゴリは最低一つ必要
        $hasSubcategory = false;
        for ($i = 1; $i <= 10; $i++) {
            if (!empty($data["subcategory{$i}"])) {
                $hasSubcategory = true;
                break;
            }
        }
        if (!$hasSubcategory) {
            return back()
                ->withErrors([
                    'subcategory' => '商品小カテゴリは1つ以上入力してください。'
                ])
                ->withInput();
        }

        session()->put('admin.category.create', $data);
        $mode = 'create';

        return view('admin.category.confirm', compact('data', 'mode'));
    }

    public function store()
    {
        $data = session('admin.category.create');
        if (!$data) {
            return redirect()->route('admin.category.create');
        }
        session()->forget('admin.category.create');

        // カテゴリ登録
        $category = ProductCategory::create([
            'name' => $data['name'],
        ]);

        // サブカテゴリ登録
        for ($i = 1; $i <= 10; $i++) {
            if (!empty($data["subcategory{$i}"])) {
                $category->subcategories()->create([
                    'name' => $data["subcategory{$i}"],
                ]);
            }
        }
        
        return redirect(session('admin_category_index_url', route('admin.category.index')));
    }

    public function show(ProductCategory $productCategory)
    {
        // リレーションを取得
        $productCategory->load('subcategories');

        return view('admin.category.show', compact('productCategory'));
    }

    public function edit(ProductCategory $productCategory)
    {

        $category = session("admin.category.edit.{$productCategory->id}");

        if (!$category) {
            // カテゴリ情報
            $category = $productCategory->toArray();

            // サブカテゴリ取得
            $productCategory->load('subcategories');
            // ビューで使いやすくする
            $names = $productCategory->subcategories->pluck('name');
            foreach ($names as $index => $name) {
                $category['subcategory' . ($index + 1)] = $name;
            }
        } else {
            $category['id'] = $productCategory->id;
        }

        $mode = 'edit';

        return view('admin.category.input', compact('category', 'mode'));
    }

    public function editConfirm(Request $request, ProductCategory $productCategory)
    {
        // バリデーション
        $rules = ['name' => ['required', 'string', 'max:20'],];
        for ($i = 1; $i <= 10; $i++) {
            $rules["subcategory{$i}"] = ['nullable', 'string', 'max:20'];
        }
        // バリデーションメッセージ用
        $attributes = [
            'name' => '商品大カテゴリ',
        ];
        for ($i = 1; $i <= 10; $i++) {
            $attributes["subcategory{$i}"] = '商品小カテゴリ';
        }
        // バリデーション実行
        $data = $request->validate($rules, [], $attributes);

        // サブカテゴリは最低一つ必要
        $hasSubcategory = false;
        for ($i = 1; $i <= 10; $i++) {
            if (!empty($data["subcategory{$i}"])) {
                $hasSubcategory = true;
                break;
            }
        }
        if (!$hasSubcategory) {
            return back()
                ->withErrors([
                    'subcategory' => '商品小カテゴリは1つ以上入力してください。'
                ])
                ->withInput();
        }       

        session()->put("admin.category.edit.{$productCategory->id}", $data);
        $mode = 'edit';

        return view('admin.category.confirm', compact('data', 'mode', 'productCategory'));
    }

    public function update(ProductCategory $productCategory)
    {
        $data = session("admin.category.edit.{$productCategory->id}", []);
        if (!$data) {
            return redirect()->route('admin.index');
        }
        session()->forget("admin.category.edit.{$productCategory->id}");

        // 念のためトランザクション化
        DB::transaction(function () use ($productCategory, $data) {
            // カテゴリ名を更新
            $productCategory->update([
                'name' => $data['name'],
            ]);
            // もともと登録されていたサブカテゴリを物理削除
            $productCategory->subcategories()->get()->each->forceDelete();
            // サブカテゴリ登録
            for ($i = 1; $i <= 10; $i++) {
                if (!empty($data["subcategory{$i}"])) {
                    $productCategory->subcategories()->create([
                        'name' => $data["subcategory{$i}"],
                    ]);
                }
            }       
        });
 
        return redirect(session('admin_category_index_url', route('admin.category.index')));
    }

    public function destroy(ProductCategory $productCategory)
    {
        // サブカテゴリをソフトデリート
        $productCategory->subcategories()->delete();
        // カテゴリをソフトデリート
        $productCategory->delete();

        return redirect(session('admin_category_index_url', route('admin.category.index')));
    }
}
