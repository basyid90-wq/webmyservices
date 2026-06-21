<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'shop_carts';

    protected $fillable = ['session_id'];

    public function items()
    {
        return $this->hasMany(CartItem::class, 'shop_cart_id');
    }
}
