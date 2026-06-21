<?php

namespace App\Filament\Widgets;

use App\Models\Shop\Order;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Revenue';
    protected static ?string $pollingInterval = null;
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(fn ($i) => Carbon::now()->subMonths($i));
        $data = $months->map(function ($month) {
            return Order::where('status', 'paid')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total');
        });

        return [
            'datasets' => [[
                'label' => 'Revenue (RM)',
                'data' => $data->toArray(),
                'fill' => 'start',
                'borderColor' => '#06b6d4',
                'backgroundColor' => 'rgba(6,182,212,0.1)',
            ]],
            'labels' => $months->map(fn ($m) => $m->format('M Y'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
