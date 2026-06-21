<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $table = 'shipments';
    protected $fillable = [
        'shop_order_id', 'shipping_provider_id', 'tracking_number',
        'status', 'tracking_history', 'estimated_delivery', 'delivered_at',
    ];
    protected $casts = [
        'tracking_history' => 'array',
        'estimated_delivery' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'shop_order_id');
    }

    public function provider()
    {
        return $this->belongsTo(ShippingProvider::class, 'shipping_provider_id');
    }

    public function addTracking(string $status, string $description, string $location = null): void
    {
        $history = $this->tracking_history ?? [];
        $history[] = [
            'status' => $status,
            'description' => $description,
            'location' => $location,
            'timestamp' => now()->toISOString(),
        ];
        $this->update([
            'status' => $status,
            'tracking_history' => $history,
        ]);
        if ($status === 'delivered') {
            $this->update(['delivered_at' => now()]);
        }
    }
}
