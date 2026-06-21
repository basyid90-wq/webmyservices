<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\DocumentResource;
use App\Models\Client;
use App\Models\Document;
use App\Models\DocumentItem;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PerluRenew extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Client::query()
                    ->where('is_subscription_active', true)
                    ->where(function (Builder $q) {
                        $q->where(function (Builder $q) {
                            $q->whereNotNull('domain_expiry_date')
                                ->where('domain_expiry_date', '<=', now()->addDays(60))
                                ->where('status_renew', '!=', 'sudah_renew');
                        })->orWhere(function (Builder $q) {
                            $q->whereNotNull('hosting_expiry_date')
                                ->where('hosting_expiry_date', '<=', now()->addDays(60))
                                ->where('status_renew', '!=', 'sudah_renew');
                        });
                    })
                    ->orderByRaw("LEAST(COALESCE(domain_expiry_date, '2099-12-31'), COALESCE(hosting_expiry_date, '2099-12-31')) ASC")
            )
            ->heading('Perlu Renew < 60 Hari')
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

                TextColumn::make('butiran')
                    ->label('Butiran')
                    ->state(function ($record) {
                        $parts = [];
                        if ($record->domain_expiry_date && $record->status_renew !== 'sudah_renew' && $record->baki_domain !== null) {
                            $parts[] = "Domain: {$record->baki_domain} hari";
                        }
                        if ($record->hosting_expiry_date && $record->status_renew !== 'sudah_renew' && $record->baki_hosting !== null) {
                            $parts[] = "Hosting: {$record->baki_hosting} hari";
                        }
                        return implode(' | ', $parts) ?: '-';
                    })
                    ->color(function ($record) {
                        $minDays = PHP_INT_MAX;
                        if ($record->domain_expiry_date && $record->status_renew !== 'sudah_renew' && $record->baki_domain !== null) {
                            $minDays = min($minDays, $record->baki_domain);
                        }
                        if ($record->hosting_expiry_date && $record->status_renew !== 'sudah_renew' && $record->baki_hosting !== null) {
                            $minDays = min($minDays, $record->baki_hosting);
                        }
                        if ($minDays === PHP_INT_MAX) return null;
                        if ($minDays <= 45) return 'danger';
                        if ($minDays <= 60) return 'warning';
                        return 'success';
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('buatInvois')
                    ->label('Buat Invois')
                    ->icon('heroicon-o-document-plus')
                    ->action(function ($record) {
                        $items = [];
                        if ($record->domain_price_sell > 0) {
                            $items[] = [
                                'item_desc' => 'Domain Renewal: ' . $record->domain_name,
                                'qty' => 1,
                                'unit_price' => $record->domain_price_sell,
                                'line_discount' => 0,
                                'line_total' => $record->domain_price_sell,
                                'sort_order' => 0,
                            ];
                        }
                        if ($record->hosting_price_sell > 0) {
                            $items[] = [
                                'item_desc' => 'Hosting Renewal: ' . ($record->hosting_name ?: 'Hosting'),
                                'qty' => 1,
                                'unit_price' => $record->hosting_price_sell,
                                'line_discount' => 0,
                                'line_total' => $record->hosting_price_sell,
                                'sort_order' => 1,
                            ];
                        }

                        if (empty($items)) {
                            Notification::make()->title('Tiada item untuk diinvois')->warning()->send();
                            return;
                        }

                        $subtotal = collect($items)->sum('line_total');

                        $doc = Document::create([
                            'doc_type' => 'INVOICE',
                            'doc_date' => now(),
                            'due_date' => now()->addDays(14),
                            'status' => 'Draft',
                            'client_id' => $record->id,
                            'bill_to_name' => $record->name,
                            'bill_to_email' => $record->email,
                            'bill_to_phone' => $record->phone,
                            'bill_to_address' => $record->address,
                            'subtotal' => $subtotal,
                            'discount_amount' => 0,
                            'tax_percent' => 0,
                            'tax_amount' => 0,
                            'grand_total' => $subtotal,
                            'currency' => 'MYR',
                        ]);

                        foreach ($items as $item) {
                            DocumentItem::create([
                                'document_id' => $doc->id,
                                'item_desc' => $item['item_desc'],
                                'qty' => $item['qty'],
                                'unit_price' => $item['unit_price'],
                                'line_discount' => $item['line_discount'],
                                'line_total' => $item['line_total'],
                                'sort_order' => $item['sort_order'],
                            ]);
                        }

                        return redirect(DocumentResource::getUrl('edit', ['record' => $doc]));
                    }),
            ]);
    }
}
