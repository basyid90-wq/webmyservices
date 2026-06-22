<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationGroup = 'Frontend';

    protected static ?string $navigationLabel = 'Contacts';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Pelan & Kenalan')
                    ->schema([
                        Forms\Components\TextInput::make('plan_name')
                            ->label('Pakej Dipilih')
                            ->disabled()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Penuh')
                            ->disabled()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('company_name')
                            ->label('Nama Syarikat / Jenama')
                            ->disabled()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Emel')
                            ->disabled()
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->disabled()
                            ->maxLength(255),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Maklumat Projek')
                    ->schema([
                        Forms\Components\TextInput::make('subject')
                            ->label('Subjek')
                            ->disabled()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('industry')
                            ->label('Industri')
                            ->disabled()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('website_goal')
                            ->label('Tujuan Website')
                            ->disabled()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('reference_urls')
                            ->label('Link Rujukan')
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('content_status')
                            ->label('Status Kandungan')
                            ->disabled()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('additional_budget')
                            ->label('Bajet Tambahan')
                            ->disabled()
                            ->prefix('RM'),
                        Forms\Components\Textarea::make('message')
                            ->label('Mesej / Nota')
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Forms\Components\Toggle::make('is_read')
                    ->label('Telah Dibaca'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('plan_name')
                    ->label('Pakej')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'Enterprise' => 'warning',
                        'Professional' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company_name')
                    ->label('Syarikat')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('whatsapp')
                    ->label('WhatsApp')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email')
                    ->label('Emel'),
                Tables\Columns\TextColumn::make('industry')
                    ->label('Industri')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('website_goal')
                    ->label('Tujuan')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('content_status')
                    ->label('Kandungan')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_read')
                    ->label('Dibaca')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarikh')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('plan_name')
                    ->label('Pakej')
                    ->options([
                        'Starter' => 'Starter',
                        'Professional' => 'Professional',
                        'Enterprise' => 'Enterprise',
                    ]),
                Tables\Filters\Filter::make('is_read')
                    ->toggle()
                    ->query(fn ($query) => $query->where('is_read', false))
                    ->label('Belum Dibaca'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Lihat'),
                Tables\Actions\Action::make('markRead')
                    ->label('Tandakan Dibaca')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn ($record) => $record->update(['is_read' => true]))
                    ->hidden(fn ($record) => $record->is_read),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Padam'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListContacts::route('/'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
