<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RentalReceiptResource\Pages;
use App\Filament\Resources\RentalReceiptResource\RelationManagers;
use App\Models\RentalReceipt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RentalReceiptResource extends Resource
{
    protected static ?string $model = RentalReceipt::class;

    protected static ?string $navigationGroup = 'Barakah Transport';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Rental Receipts';

    protected static ?string $recordTitleAttribute = 'receipt_number';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Maklumat Pelanggan')
                    ->schema([
                        Forms\Components\TextInput::make('customer_name')
                            ->label('Nama Pelanggan')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('customer_phone')
                            ->label('No. Telefon')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('payment_method')
                            ->label('Kaedah Bayaran')
                            ->options([
                                'cash' => 'Tunai',
                                'transfer' => 'Bank Transfer',
                                'card' => 'Kad',
                            ])
                            ->default('cash')
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Item Sewaan')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->label('Item')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('category')
                                    ->label('Kategori')
                                    ->options([
                                        'scooter' => 'Skuter',
                                        'motorcycle' => 'Motosikal',
                                        'car' => 'Kereta',
                                        'homestay' => 'Homestay',
                                    ])
                                    ->reactive()
                                    ->required(),
                                Forms\Components\TextInput::make('model_unit')
                                    ->label('Model / Unit')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('quantity')
                                    ->label('Kuantiti')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->required(),
                                Forms\Components\DatePicker::make('start_date')
                                    ->label('Tarikh Mula')
                                    ->reactive()
                                    ->required(),
                                Forms\Components\DatePicker::make('end_date')
                                    ->label('Tarikh Akhir')
                                    ->reactive()
                                    ->afterOrEqual('start_date')
                                    ->required(),
                                Forms\Components\TextInput::make('duration_days')
                                    ->label('Tempoh (Hari)')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated(true),
                                Forms\Components\TextInput::make('price_per_day')
                                    ->label('Harga Sehari (RM)')
                                    ->numeric()
                                    ->prefix('RM')
                                    ->reactive()
                                    ->required(),
                                Forms\Components\Select::make('price_type')
                                    ->label('Jenis Harga')
                                    ->options([
                                        'per_day' => 'Per Hari (harga × hari)',
                                        'flat' => 'Sekali Bayar (harga tetap)',
                                    ])
                                    ->default('per_day')
                                    ->reactive()
                                    ->required(),
                                Forms\Components\TextInput::make('total_price')
                                    ->label('Jumlah (RM)')
                                    ->numeric()
                                    ->prefix('RM')
                                    ->disabled()
                                    ->dehydrated(true),
                            ])
                            ->columns(2)
                            ->columnSpanFull()
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                $data = self::calcItemTotals($data);
                                return $data;
                            }),
                    ]),

                Forms\Components\Section::make('Bayaran')
                    ->schema([
                        Forms\Components\TextInput::make('deposit_amount')
                            ->label('Deposit (RM)')
                            ->numeric()
                            ->prefix('RM')
                            ->default(0)
                            ->reactive()
                            ->required(),
                        Forms\Components\Placeholder::make('total_amount_display')
                            ->label('Jumlah Keseluruhan')
                            ->content(fn ($get) => 'RM ' . number_format((float) $get('total_amount'), 2))
                            ->visible(fn ($get) => $get('total_amount') > 0),
                        Forms\Components\Placeholder::make('balance_display')
                            ->label('Baki Perlu Dibayar')
                            ->content(fn ($get) => 'RM ' . number_format(max(0, (float) $get('total_amount') - (float) $get('deposit_amount')), 2))
                            ->visible(fn ($get) => $get('total_amount') > 0),
                    ])
                    ->columns(1),
            ]);
    }

    public static function calcItemTotals(array $data): array
    {
        $start = $data['start_date'] ?? null;
        $end = $data['end_date'] ?? null;
        $price = (float) ($data['price_per_day'] ?? 0);
        $qty = (int) ($data['quantity'] ?? 1);
        $priceType = $data['price_type'] ?? 'per_day';

        if ($start && $end) {
            $data['duration_days'] = max(1, (int) \Carbon\Carbon::parse($start)->diffInDays(\Carbon\Carbon::parse($end)));
        }

        if ($priceType === 'flat') {
            $data['total_price'] = $price;
        } else {
            $data['total_price'] = $price * ($data['duration_days'] ?? 1) * $qty;
        }

        return $data;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('receipt_number')
                    ->label('No. Resit')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_phone')
                    ->label('Telefon')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Bayaran')
                    ->badge()
                    ->formatStateUsing(fn ($s) => match($s) { 'cash' => 'Tunai', 'transfer' => 'Transfer', default => $s }),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Jumlah')
                    ->money('MYR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('deposit_amount')
                    ->label('Deposit')
                    ->money('MYR')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('balance_amount')
                    ->label('Baki')
                    ->money('MYR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarikh')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Bayaran')
                    ->options([
                        'cash' => 'Tunai',
                        'transfer' => 'Bank Transfer',
                        'card' => 'Kad',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit'),
                Tables\Actions\Action::make('print')
                    ->label('Cetak')
                    ->icon('heroicon-o-printer')
                    ->url(fn (RentalReceipt $r) => route('rental.print', $r))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('download')
                    ->label('PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn (RentalReceipt $r) => route('rental.download', $r))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Padam'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRentalReceipts::route('/'),
            'create' => Pages\CreateRentalReceipt::route('/create'),
            'edit' => Pages\EditRentalReceipt::route('/{record}/edit'),
        ];
    }
}
