<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'shop_categories';
    protected $fillable = ['name', 'slug', 'description', 'icon', 'sort_order', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function products()
    {
        return $this->hasMany(Product::class, 'shop_category_id');
    }
}
