<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class ReviewController extends Controller
{
    // レビュー登録画面を表示
    public function create(Product $product)
    {
        $review = session("review.{$product->id}", []);
        $average = $product->reviews()->avg('evaluation');

        return view('review.create', compact('product', 'review', 'average'));
    }

    // 登録内容確認画面
    public function confirm(Request $request, Product $product)
    {
        $data = $request->validate([
            'evaluation' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:500',],
        ]);

        session()->put("review.{$product->id}", $data);

        $average = $product->reviews()->avg('evaluation');

        return view('review.confirm', compact('data', 'product', 'average'));
    }

    // DB登録
    public function store(Request $request, Product $product)
    {
        $data = session("review.{$product->id}", []);
        if (!$data) {
            return redirect()->route('top');
        }
 
        Review::create([
            'member_id' => Auth::id(),
            'product_id' => $product->id,
            'evaluation' => $data['evaluation'],
            'comment' => $data['comment'],
        ]);
 
        session()->forget("review.{$product->id}");
 
        return view('review.store', compact('product'));
    }

}
