<?php

namespace App\Filament\Widgets;

use App\Models\Shop\Order;
use App\Models\Shop\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ShopStatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $revenue = Order::where('status', 'paid')->sum('total');
        $orders = Order::count();
        $customers = User::count();
        $products = Product::where('is_active', true)->count();

        return [
            Stat::make('Revenue', 'RM ' . number_format($revenue, 2))
                ->description('Total paid orders')
                ->color('success')
                ->icon('heroicon-o-banknotes'),
            Stat::make('Orders', $orders)
                ->description($orders > 0 ? Order::where('status', 'pending')->count() . ' pending' : 'No orders yet')
                ->color('warning')
                ->icon('heroicon-o-shopping-bag'),
            Stat::make('Customers', $customers)
                ->description('Registered users')
                ->color('info')
                ->icon('heroicon-o-users'),
            Stat::make('Products', $products)
                ->description($products . ' active products')
                ->color('primary')
                ->icon('heroicon-o-cube'),
        ];
    }
}
