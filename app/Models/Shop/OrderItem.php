<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'shop_order_items';

    protected $fillable = [
        'shop_order_id', 'shop_product_id', 'product_name', 'price', 'quantity', 'subtotal',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'shop_order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'shop_product_id');
    }
}
