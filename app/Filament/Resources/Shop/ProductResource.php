<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\ProductResource\Pages;
use App\Models\Shop\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Shop (Demo)';
    protected static ?string $navigationLabel = 'Products';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('shop_category_id')->relationship('category', 'name')->required(),
            Forms\Components\TextInput::make('name')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),
            Forms\Components\RichEditor::make('description')->columnSpanFull(),
            Forms\Components\TextInput::make('price')->numeric()->prefix('RM')->required(),
            Forms\Components\TextInput::make('compare_price')->numeric()->prefix('RM'),
            Forms\Components\FileUpload::make('image')->directory('shop-products')->image(),
            Forms\Components\TextInput::make('unit'),
            Forms\Components\TextInput::make('weight_grams')->numeric(),
            Forms\Components\TextInput::make('stock')->numeric()->default(0)->required(),
            Forms\Components\Toggle::make('is_active')->default(true),
            Forms\Components\Toggle::make('is_featured')->default(false),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image')->square(),
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('category.name'),
            Tables\Columns\TextColumn::make('price')->money('MYR')->sortable(),
            Tables\Columns\TextColumn::make('stock')->sortable()
                ->color(fn ($state) => $state <= 5 ? 'danger' : ($state <= 15 ? 'warning' : 'success'))
                ->icon(fn ($state) => $state <= 5 ? 'heroicon-o-exclamation-triangle' : null),
            Tables\Columns\IconColumn::make('is_active')->boolean(),
        ])->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
