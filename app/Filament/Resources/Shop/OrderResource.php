<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\OrderResource\Pages;
use App\Models\Shop\Order;
use App\Models\Shop\ShippingProvider;
use App\Models\Shop\Shipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Shop (Demo)';
    protected static ?string $navigationLabel = 'Orders (Test Live)';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('order_number')->disabled(),
            Forms\Components\TextInput::make('customer_name'),
            Forms\Components\TextInput::make('customer_email'),
            Forms\Components\Select::make('status')->options([
                'pending' => 'Pending', 'paid' => 'Paid', 'processing' => 'Processing',
                'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled',
            ])->required(),
            Forms\Components\TextInput::make('total')->numeric()->prefix('RM')->disabled(),
            Forms\Components\Textarea::make('shipping_address'),
            Forms\Components\Textarea::make('notes'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('order_number')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('customer_name')->searchable(),
            Tables\Columns\TextColumn::make('total')->money('MYR')->sortable(),
            Tables\Columns\SelectColumn::make('status')->options([
                'pending' => 'Pending', 'paid' => 'Paid', 'processing' => 'Processing',
                'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled',
            ])->sortable(),
            Tables\Columns\TextColumn::make('created_at')->dateTime('d/m/Y H:i')->sortable(),
        ])
        ->defaultSort('created_at', 'desc')
        ->actions([
            Tables\Actions\EditAction::make(),
            Action::make('createShipment')->label('Ship')->icon('heroicon-o-truck')
                ->form([
                    Forms\Components\Select::make('shipping_provider_id')->label('Courier')->options(ShippingProvider::pluck('name', 'id'))->required(),
                    Forms\Components\TextInput::make('tracking_number')->required(),
                ])
                ->action(function (Order $record, array $data) {
                    Shipment::create([
                        'shop_order_id' => $record->id,
                        'shipping_provider_id' => $data['shipping_provider_id'],
                        'tracking_number' => $data['tracking_number'],
                        'status' => 'processing',
                    ]);
                    $record->update(['status' => 'processing']);
                })
                ->visible(fn (Order $r) => !$r->shipment),
        ])
        ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
