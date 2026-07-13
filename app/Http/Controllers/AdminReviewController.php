<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;

class AdminReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::query();

        // ID
        if ($request->filled('review_id')) {
            $query->where('id', $request->review_id);
        }

        // フリーワード
        if ($request->filled('freeword')) {
            $freeword = $request->freeword;
            $query->where(function ($q) use ($freeword) {
                // カテゴリ名
                $q->where('comment', 'like', "%{$freeword}%");
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

        $reviews = $query->paginate(10)->withQueryString();


        // 検索条件をビューへ渡す
        $review_search = $request->only([
            'review_id',
            'freeword',
        ]);

        session(['admin_review_index_url' => url()->full()]);

        return view('admin.review.index', compact('reviews', 'review_search'));
    }

    public function create()
    {
        $review = session('admin.review.create');
        $users = User::select('id', 'name_sei', 'name_mei')->get();
        $products = Product::select('id', 'name')->get();
        $mode = 'create';

        return view('admin.review.input', compact('review', 'mode', 'users', 'products'));
    }

    public function createConfirm(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'member_id' => ['required', 'integer', 'exists:members,id'],
            'evaluation' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:500',],
        ]);

        session()->put('admin.review.create', $data);
        $mode = 'create';

        $user = User::find($data['member_id']);
        $product = Product::find($data['product_id']);
        $average = $product->reviews()->avg('evaluation');

        return view('admin.review.confirm', compact('data', 'mode', 'user', 'product', 'average'));
    }

    public function store()
    {
        $data = session('admin.review.create');
        if (!$data) {
            return redirect()->route('admin.review.create');
        }
        session()->forget('admin.review.create');

        // カテゴリ登録
        Review::create($data);

        return redirect(session('admin_review_index_url', route('admin.review.index')));
    }

    public function show(Review $review)
    {
        // リレーションを取得
        $review->load(['product']);
        // 総合評価を取得
        $average = $review->product->reviews()->avg('evaluation');

        return view('admin.review.show', compact('review', 'average'));
    }

    public function edit(Review $reviewModel)
    {
        $review = session("admin.review.edit.{$reviewModel->id}");

        if (!$review) {
            // レビュー情報をDBから取得
            // ビューで使いやすいように配列にする
            $review = $reviewModel->toArray();
        } else {
            // セッションから取得した場合IDがないのでモデルから取得
            $review['id'] = $reviewModel->id;
        }

        $users = User::select('id', 'name_sei', 'name_mei')->get();
        $products = Product::select('id', 'name')->get();
        $mode = 'edit';

        return view('admin.review.input', compact('review', 'mode', 'users', 'products'));
    }

    public function editConfirm(Request $request, Review $review)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'member_id' => ['required', 'integer', 'exists:members,id'],
            'evaluation' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:500',],
        ]);

        session()->put("admin.review.edit.{$review->id}", $data);
        $mode = 'edit';

        $user = User::find($data['member_id']);
        $product = Product::find($data['product_id']);
        $average = $product->reviews()->avg('evaluation');

        return view('admin.review.confirm', compact('data', 'mode', 'user', 'product', 'average', 'review'));
    }

    public function update(Review $review)
    {
        $data = session("admin.review.edit.{$review->id}", []);
        if (!$data) {
            return redirect()->route('admin.index');
        }
        session()->forget("admin.review.edit.{$review->id}");

        $review->update($data);
        
        return redirect(session('admin_review_index_url', route('admin.review.index')));
    }

    public function destroy(Review $review)
    {
        // レビューをソフトデリート
        $review->delete();

        return redirect(session('admin_review_index_url', route('admin.review.index')));
    }

}

