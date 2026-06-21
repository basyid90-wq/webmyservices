<?php

namespace Database\Seeders;

use App\Models\Shop\Coupon;
use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use App\Models\Shop\Product;
use App\Models\Shop\Shipment;
use App\Models\Shop\ShippingProvider;
use App\Models\User;
use Illuminate\Database\Seeder;

class ShopDemoSeeder extends Seeder
{
    public function run(): void
    {
        Coupon::firstOrCreate(['code' => 'RAYA2026'], [
            'type' => 'percent', 'value' => 20,
            'min_order' => 50, 'max_discount' => 30,
            'usage_limit' => 100, 'used_count' => 12, 'expires_at' => now()->addMonths(6),
        ]);
        Coupon::firstOrCreate(['code' => 'WELCOME10'], [
            'type' => 'fixed', 'value' => 10,
            'min_order' => 30, 'usage_limit' => 50, 'used_count' => 8,
            'expires_at' => now()->addMonths(3),
        ]);
        Coupon::firstOrCreate(['code' => 'HASILLAUT'], [
            'type' => 'percent', 'value' => 15,
            'min_order' => 20, 'max_discount' => 15, 'expires_at' => now()->addYear(),
        ]);

        $providers = ShippingProvider::all();
        $products = Product::where('is_active', true)->get();

        $user = User::where('email', 'demo@hasillaut.com')->first();
        if ($user) { $user->phone = $user->phone ?: '0123456789'; $user->save(); }

        $statuses = ['paid', 'paid', 'paid', 'processing', 'shipped', 'delivered', 'delivered'];
        for ($i = 0; $i < 7; $i++) {
            $items = $products->random(rand(2, 4));
            $subtotal = $items->sum('price');
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'HL-2506' . str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone,
                'shipping_address' => 'No 2-2A Taman Desa Pangkor',
                'shipping_city' => 'Pangkor',
                'shipping_state' => 'Perak',
                'shipping_postcode' => '32300',
                'subtotal' => $subtotal,
                'shipping_fee' => $subtotal > 100 ? 0 : 10,
                'total' => $subtotal + ($subtotal > 100 ? 0 : 10),
                'status' => $statuses[$i],
                'created_at' => now()->subDays(rand(1, 60)),
            ]);
            foreach ($items as $p) {
                OrderItem::create([
                    'shop_order_id' => $order->id,
                    'shop_product_id' => $p->id,
                    'product_name' => $p->name,
                    'price' => $p->price,
                    'quantity' => 1,
                    'subtotal' => $p->price,
                ]);
            }
            $provider = $providers->random();
            $shipment = Shipment::create([
                'shop_order_id' => $order->id,
                'shipping_provider_id' => $provider->id,
                'tracking_number' => strtoupper(substr($provider->code, 0, 2)) . '-' . rand(10000000, 99999999),
                'status' => in_array($order->status, ['processing', 'shipped', 'delivered']) ? $order->status : 'pending',
                'estimated_delivery' => now()->addDays(rand(2, 7)),
            ]);
            if ($order->status === 'shipped') {
                $shipment->addTracking('processing', 'Pesanan sedang diproses di gudang', 'Kuala Lumpur');
                $shipment->addTracking('shipped', 'Bungkusan telah diambil oleh kurier', 'Ipoh');
            } elseif ($order->status === 'delivered') {
                $shipment->addTracking('processing', 'Pesanan sedang diproses di gudang', 'Kuala Lumpur');
                $shipment->addTracking('shipped', 'Bungkusan telah diambil oleh kurier', 'Ipoh');
                $shipment->addTracking('delivered', 'Bungkusan telah selamat diterima', 'Pangkor');
            }
        }
    }
}
