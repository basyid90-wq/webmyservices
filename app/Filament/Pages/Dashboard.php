<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardStats;
use App\Filament\Widgets\HostingByProvider;
use App\Filament\Widgets\PerluRenew;
use App\Filament\Widgets\WpPluginOverdue;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            DashboardStats::class,
            PerluRenew::class,
            WpPluginOverdue::class,
            HostingByProvider::class,
        ];
    }
}
