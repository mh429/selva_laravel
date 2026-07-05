<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'member_id',
        'name',
        'product_category_id',
        'product_subcategory_id',
        'image_1',
        'image_2',        
        'image_3',
        'image_4',        
        'product_content',
    ];

    // リレーション
    public function user()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(ProductSubcategory::class);
    }
}
