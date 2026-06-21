<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class ShippingProvider extends Model
{
    protected $table = 'shipping_providers';
    protected $fillable = ['name', 'code', 'logo_url', 'description', 'is_active', 'sort_order'];
    protected $casts = ['is_active' => 'boolean'];
}
