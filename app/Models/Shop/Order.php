<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'shop_orders';
    protected $fillable = [
        'user_id', 'order_number', 'customer_name', 'customer_email', 'customer_phone',
        'shipping_address', 'shipping_city', 'shipping_state', 'shipping_postcode',
        'subtotal', 'shipping_fee', 'total', 'coupon_code', 'discount', 'status', 'notes',
        'payment_channel', 'payment_reference', 'transaction_id', 'paid_at',
    ];
    protected $casts = ['paid_at' => 'datetime'];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'shop_order_id');
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class, 'shop_order_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'HL-';
        $date = now()->format('ymd');
        $count = static::whereDate('created_at', today())->count() + 1;
        return $prefix . $date . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
    }
}
