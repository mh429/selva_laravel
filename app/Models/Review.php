<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'member_id',
        'product_id',
        'evaluation',
        'comment',
    ];

    // リレーション
    public function user()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
