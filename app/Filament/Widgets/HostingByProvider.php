<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class HostingByProvider extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        $stats = [];
        $providers = Client::where('is_subscription_active', true)
            ->whereNotNull('hosting_name')
            ->selectRaw('hosting_name, count(*) as total')
            ->groupBy('hosting_name')
            ->orderByDesc('total')
            ->get();

        foreach ($providers as $p) {
            $stats[] = Stat::make($p->hosting_name, $p->total)
                ->icon('heroicon-o-server-stack');
        }
        return $stats ?: [Stat::make('Hosting', 0)->icon('heroicon-o-server')];
    }
}
