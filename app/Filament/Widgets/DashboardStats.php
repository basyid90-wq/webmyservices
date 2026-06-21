<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use App\Models\Document;
use App\Models\Invoice;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    protected function getStats(): array
    {
        $totalKeuntungan = Client::where('is_subscription_active', true)->sum('domain_price_sell')
            + Client::where('is_subscription_active', true)->sum('hosting_price_sell');

        $domainAktif = Client::where('is_subscription_active', true)
            ->whereNotNull('domain_name')
            ->count();

        $hostingAktif = Client::where('is_subscription_active', true)
            ->whereNotNull('hosting_name')
            ->count();

        return [
            Stat::make('Jumlah Domain (Aktif)', $domainAktif)
                ->icon('heroicon-o-globe-alt')
                ->color('success'),
            Stat::make('Jumlah Hosting (Aktif)', $hostingAktif)
                ->icon('heroicon-o-server')
                ->color('info'),
            Stat::make('Jumlah Keuntungan (RM)', number_format($totalKeuntungan, 2))
                ->icon('heroicon-o-currency-dollar')
                ->color('warning'),
            Stat::make('Total Documents', Document::count())
                ->icon('heroicon-o-document-arrow-up'),
            Stat::make('Total Projects', Project::count())
                ->icon('heroicon-o-computer-desktop'),
        ];
    }
}
