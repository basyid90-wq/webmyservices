<?php

namespace Database\Seeders;

use App\Models\Shop\ShippingProvider;
use App\Models\Shop\Shipment;
use App\Models\Shop\Order;
use Illuminate\Database\Seeder;

class ShippingSeeder extends Seeder
{
    public function run(): void
    {
        $providers = [
            ['name' => 'J&T Express', 'code' => 'jnt', 'description' => 'Penghantaran pantas seluruh Malaysia'],
            ['name' => 'Ninja Van', 'code' => 'ninja', 'description' => 'Penghantaran ke seluruh Malaysia & Singapura'],
            ['name' => 'Skynet', 'code' => 'skynet', 'description' => 'Penghantaran domestik & antarabangsa'],
            ['name' => 'Pos Laju', 'code' => 'poslaju', 'description' => 'Perkhidmatan pos nasional'],
        ];

        foreach ($providers as $i => $p) {
            ShippingProvider::create([...$p, 'sort_order' => $i]);
        }

        $orders = Order::all();
        foreach ($orders as $order) {
            $provider = ShippingProvider::inRandomOrder()->first();
            $shipment = Shipment::create([
                'shop_order_id' => $order->id,
                'shipping_provider_id' => $provider->id,
                'tracking_number' => strtoupper(substr($provider->code, 0, 2)) . '-' . rand(10000000, 99999999),
                'status' => $order->status === 'paid' ? 'processing' : 'pending',
                'estimated_delivery' => now()->addDays(rand(2, 7)),
            ]);
            if ($order->status === 'paid') {
                $shipment->addTracking('processing', 'Pesanan sedang diproses di gudang', 'Kuala Lumpur');
                $shipment->addTracking('shipped', 'Bungkusan telah diambil oleh kurier', 'Kuala Lumpur');
            }
        }
    }
}
