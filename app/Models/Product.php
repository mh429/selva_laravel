<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

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
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(ProductSubcategory::class, 'product_subcategory_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // アクセサ
    public function getThumbnailAttribute(): ?string
    {
        foreach (['image_1', 'image_2', 'image_3', 'image_4'] as $column) {
            if (!empty($this->$column)) {
                return $this->$column;
            }
        }
        return null;
    }

    public function getImagesAttribute(): array
    {
        return collect([
            $this->image_1,
            $this->image_2,
            $this->image_3,
            $this->image_4,
        ])->filter()->values()->all();
    }
}
