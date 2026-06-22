<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\CouponResource\Pages;
use App\Models\Shop\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Shop (Demo)';
    protected static ?string $navigationLabel = 'Coupons (Demo)';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('code')->required()->unique(ignoreRecord: true)->uppercase(),
            Forms\Components\Select::make('type')->options(['fixed' => 'Fixed RM', 'percent' => 'Percentage %'])->required(),
            Forms\Components\TextInput::make('value')->numeric()->prefix('RM/%')->required(),
            Forms\Components\TextInput::make('min_order')->numeric()->prefix('RM')->default(0),
            Forms\Components\TextInput::make('max_discount')->numeric()->prefix('RM'),
            Forms\Components\TextInput::make('usage_limit')->numeric(),
            Forms\Components\DateTimePicker::make('starts_at'),
            Forms\Components\DateTimePicker::make('expires_at'),
            Forms\Components\Toggle::make('is_active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('code')->searchable()->sortable()->badge(),
            Tables\Columns\TextColumn::make('type')->formatStateUsing(fn ($s) => $s === 'percent' ? '%' : 'RM'),
            Tables\Columns\TextColumn::make('value')->sortable(),
            Tables\Columns\TextColumn::make('used_count')->label('Used'),
            Tables\Columns\IconColumn::make('is_active')->boolean(),
            Tables\Columns\TextColumn::make('expires_at')->dateTime('d/m/Y'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
