<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationGroup = 'Frontend';

    protected static ?string $navigationLabel = 'Our Services';

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('icon')
                    ->options([
                        'heroicon-o-code-bracket' => 'Code Bracket',
                        'heroicon-o-paint-brush' => 'Paint Brush',
                        'heroicon-o-magnifying-glass' => 'Magnifying Glass',
                        'heroicon-o-shopping-cart' => 'Shopping Cart',
                        'heroicon-o-device-phone-mobile' => 'Device Phone Mobile',
                        'heroicon-o-chart-bar' => 'Chart Bar',
                        'heroicon-o-cog' => 'Cog',
                        'heroicon-o-globe-alt' => 'Globe Alt',
                        'heroicon-o-rocket-launch' => 'Rocket Launch',
                        'heroicon-o-cursor-arrow-rays' => 'Cursor Arrow Rays',
                        'heroicon-o-bolt' => 'Bolt',
                        'heroicon-o-shield-check' => 'Shield Check',
                    ])
                    ->searchable(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\IconColumn::make('icon')
                    ->icon(fn (string $state): string => $state),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
