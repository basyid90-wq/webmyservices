<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ExpiryAlerts extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Client::query()
                    ->where('is_subscription_active', true)
                    ->where(function ($q) {
                        $q->where(function ($q) {
                            $q->whereNotNull('domain_expiry_date')
                                ->where('domain_expiry_date', '<=', now()->addDays(60))
                                ->where('status_renew', '!=', 'sudah_renew');
                        })->orWhere(function ($q) {
                            $q->whereNotNull('hosting_expiry_date')
                                ->where('hosting_expiry_date', '<=', now()->addDays(60))
                                ->where('status_renew', '!=', 'sudah_renew');
                        })->orWhere(function ($q) {
                            $q->where('website_type', 'wordpress')
                                ->whereNotNull('wp_last_plugin_update')
                                ->where('wp_last_plugin_update', '<=', now()->subDays(40));
                        });
                    })
                    ->orderByRaw("LEAST(COALESCE(domain_expiry_date, '2099-12-31'), COALESCE(hosting_expiry_date, '2099-12-31')) ASC")
            )
            ->heading('Peringatan Tamat Tempoh & WP Overdue')
            ->columns([
                TextColumn::make('domain_name')
                    ->label('Domain')
                    ->searchable(),
                TextColumn::make('company')
                    ->label('Syarikat')
                    ->searchable(),
                TextColumn::make('domain_expiry_date')
                    ->label('Luput Domain')
                    ->date()
                    ->color(fn ($record) => $this->getExpiryColor($record, 'domain')),
                TextColumn::make('hosting_expiry_date')
                    ->label('Luput Hosting')
                    ->date()
                    ->color(fn ($record) => $this->getExpiryColor($record, 'hosting')),
                TextColumn::make('status_renew')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match($state) {'aktif'=>'success','sudah_renew'=>'info','tamat'=>'danger', default=>'gray'}),
            ]);
    }

    private function getExpiryColor($record, $type): string
    {
        $date = $type === 'domain' ? $record->domain_expiry_date : $record->hosting_expiry_date;
        if (!$date) return 'gray';
        $days = now()->diffInDays($date, false);
        if ($days < 0) return 'danger';
        if ($days <= 45) return 'danger';
        if ($days <= 60) return 'warning';
        return 'success';
    }
}
