<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class WpPluginOverdue extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->heading('WP Plugin Perlu Update (>40 Hari)')
            ->query(
                Client::query()
                    ->where('website_type', 'wordpress')
                    ->whereNotNull('wp_last_plugin_update')
                    ->where('wp_last_plugin_update', '<=', now()->subDays(40)->toDateString())
                    ->where('is_subscription_active', true)
                    ->orderBy('wp_last_plugin_update', 'asc')
            )
            ->columns([
                TextColumn::make('#')
                    ->rowIndex()
                    ->label('No'),

                TextColumn::make('domain_name')
                    ->label('Domain')
                    ->searchable(),

                TextColumn::make('company')
                    ->label('Syarikat / PIC')
                    ->state(fn ($record) => $record->company ?: $record->name)
                    ->searchable(),

                TextColumn::make('wp_last_plugin_update')
                    ->label('Update Terakhir')
                    ->date()
                    ->sortable()
                    ->color(function ($record) {
                        $days = now()->diffInDays($record->wp_last_plugin_update);
                        return match (true) {
                            $days > 60 => 'danger',
                            $days > 40 => 'warning',
                            default => null,
                        };
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('telahUpdate')
                    ->label('Telah Update')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function ($record) {
                        $record->update(['wp_last_plugin_update' => now()]);
                        Notification::make()
                            ->title('Plugin dikemaskini!')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
