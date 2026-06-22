<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationGroup = 'Client Management';

    protected static ?string $navigationLabel = 'Clients Website';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Customer Info')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('company')
                                    ->maxLength(255),
                                TextInput::make('pic_name')
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('phone')
                                    ->tel()
                                    ->maxLength(255),
                                TextInput::make('website')
                                    ->url()
                                    ->maxLength(255),
                            ]),
                        Textarea::make('address')
                            ->columnSpanFull(),
                        FileUpload::make('logo')
                            ->disk('public')
                            ->directory('clients')
                            ->image(),
                        Textarea::make('notes')
                            ->columnSpanFull(),
                    ]),

                Section::make('Website & Domain Info')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('website_type')
                                    ->options([
                                        'wordpress' => 'WordPress',
                                        'custom' => 'Custom',
                                    ])
                                    ->default('custom'),
                                TextInput::make('domain_name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('domain_provider_url')
                                    ->url()
                                    ->maxLength(255),
                                TextInput::make('domain_login')
                                    ->maxLength(255),
                                TextInput::make('domain_password')
                                    ->maxLength(255),
                                TextInput::make('domain_price_cost')
                                    ->numeric()
                                    ->prefix('RM'),
                                TextInput::make('domain_price_sell')
                                    ->numeric()
                                    ->prefix('RM'),
                                DatePicker::make('domain_start_date'),
                                DatePicker::make('domain_expiry_date'),
                            ]),
                    ]),

                Section::make('Hosting Info')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('hosting_name')
                                    ->maxLength(255),
                                TextInput::make('hosting_provider_url')
                                    ->url()
                                    ->maxLength(255),
                                TextInput::make('hosting_login')
                                    ->maxLength(255),
                                TextInput::make('hosting_password')
                                    ->maxLength(255),
                                TextInput::make('hosting_price_cost')
                                    ->numeric()
                                    ->prefix('RM'),
                                TextInput::make('hosting_price_sell')
                                    ->numeric()
                                    ->prefix('RM'),
                                DatePicker::make('hosting_start_date'),
                                DatePicker::make('hosting_expiry_date'),
                            ]),
                    ]),

                Section::make('WordPress Info')
                    ->hidden(fn ($get) => $get('website_type') !== 'wordpress')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('wp_login')
                                    ->maxLength(255),
                                TextInput::make('wp_password')
                                    ->maxLength(255),
                                DatePicker::make('wp_last_plugin_update'),
                            ]),
                    ]),

                Section::make('Status')
                    ->schema([
                        Select::make('status_renew')
                            ->options([
                                'aktif' => 'Aktif',
                                'sudah_renew' => 'Sudah Renew',
                                'tamat' => 'Tamat',
                            ])
                            ->default('aktif'),
                        Toggle::make('is_subscription_active')
                            ->default(true),
                    ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Customer Info')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('name'),
                                Infolists\Components\TextEntry::make('company'),
                                Infolists\Components\TextEntry::make('pic_name'),
                                Infolists\Components\TextEntry::make('email')
                                    ->copyable(),
                                Infolists\Components\TextEntry::make('phone')
                                    ->copyable(),
                                Infolists\Components\TextEntry::make('website')
                                    ->copyable(),
                            ]),
                        Infolists\Components\TextEntry::make('address')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('notes')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Infolists\Components\Section::make('Website & Domain Info')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('website_type')
                                    ->badge()
                                    ->color(fn ($state) => $state === 'wordpress' ? 'success' : 'gray'),
                                Infolists\Components\TextEntry::make('domain_name'),
                                Infolists\Components\TextEntry::make('domain_provider_url')
                                    ->copyable(),
                                Infolists\Components\TextEntry::make('domain_login')
                                    ->copyable(),
                                Infolists\Components\TextEntry::make('domain_password')
                                    ->copyable(),
                                Infolists\Components\TextEntry::make('domain_price_cost')
                                    ->money('MYR'),
                                Infolists\Components\TextEntry::make('domain_price_sell')
                                    ->money('MYR'),
                                Infolists\Components\TextEntry::make('domain_start_date')
                                    ->date(),
                                Infolists\Components\TextEntry::make('domain_expiry_date')
                                    ->date(),
                            ]),
                    ]),

                Infolists\Components\Section::make('Hosting Info')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('hosting_name'),
                                Infolists\Components\TextEntry::make('hosting_provider_url')
                                    ->copyable(),
                                Infolists\Components\TextEntry::make('hosting_login')
                                    ->copyable(),
                                Infolists\Components\TextEntry::make('hosting_password')
                                    ->copyable(),
                                Infolists\Components\TextEntry::make('hosting_price_cost')
                                    ->money('MYR'),
                                Infolists\Components\TextEntry::make('hosting_price_sell')
                                    ->money('MYR'),
                                Infolists\Components\TextEntry::make('hosting_start_date')
                                    ->date(),
                                Infolists\Components\TextEntry::make('hosting_expiry_date')
                                    ->date(),
                            ]),
                    ]),

                Infolists\Components\Section::make('WordPress Info')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('wp_login')
                                    ->copyable(),
                                Infolists\Components\TextEntry::make('wp_password')
                                    ->copyable(),
                                Infolists\Components\TextEntry::make('wp_last_plugin_update')
                                    ->date(),
                            ]),
                    ])
                    ->hidden(fn ($record) => $record->website_type !== 'wordpress'),

                Infolists\Components\Section::make('Status')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('status_renew')
                                    ->badge()
                                    ->color(fn ($state) => match ($state) {
                                        'aktif' => 'success',
                                        'sudah_renew' => 'info',
                                        'tamat' => 'danger',
                                        default => 'gray',
                                    }),
                                Infolists\Components\IconEntry::make('is_subscription_active')
                                    ->boolean(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('domain_expiry_date')
            ->columns([
                Tables\Columns\TextColumn::make('No')
                    ->rowIndex(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('domain_name')
                    ->searchable(),
                TextColumn::make('company')
                    ->searchable(),
                TextColumn::make('website_type')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'wordpress' => 'success',
                        'custom' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('domain_expiry_date')
                    ->date()
                    ->sortable()
                    ->color(fn ($record) => match (true) {
                        $record->baki_domain < 0 => 'danger',
                        $record->baki_domain <= 45 => 'danger',
                        $record->baki_domain <= 60 => 'warning',
                        default => 'success',
                    })
                    ->extraAttributes(fn ($record) => $record->baki_domain !== null && $record->baki_domain < 0
                        ? ['class' => 'animate-pulse']
                        : []),
                TextColumn::make('status_renew')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'aktif' => 'success',
                        'sudah_renew' => 'info',
                        'tamat' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                SelectFilter::make('website_type')
                    ->options([
                        'wordpress' => 'WordPress',
                        'custom' => 'Custom',
                    ]),
                SelectFilter::make('status_renew')
                    ->options([
                        'aktif' => 'Aktif',
                        'sudah_renew' => 'Sudah Renew',
                        'tamat' => 'Tamat',
                    ]),
                TernaryFilter::make('is_subscription_active'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ClientResource\RelationManagers\PluginsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'view' => Pages\ViewClient::route('/{record}'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
