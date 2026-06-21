<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'shop_cart_items';

    protected $fillable = ['shop_cart_id', 'shop_product_id', 'quantity'];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'shop_cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'shop_product_id');
    }
}
