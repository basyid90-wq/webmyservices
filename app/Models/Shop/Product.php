<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'shop_products';
    protected $fillable = [
        'shop_category_id', 'name', 'slug', 'description', 'price', 'compare_price',
        'image', 'images', 'unit', 'weight_grams', 'stock', 'is_active', 'is_featured', 'sort_order',
    ];
    protected $casts = ['images' => 'array', 'is_active' => 'boolean', 'is_featured' => 'boolean', 'price' => 'decimal:2', 'compare_price' => 'decimal:2'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'shop_category_id');
    }
}
