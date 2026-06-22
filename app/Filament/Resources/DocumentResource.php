<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationGroup = 'Client Management';

    protected static ?string $navigationLabel = 'Sebutharga/Invoice/Resit';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $recordTitleAttribute = 'doc_no';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Document Info')
                    ->schema([
                        Forms\Components\Select::make('doc_type')
                            ->options([
                                'QUOTE' => 'Quote',
                                'INVOICE' => 'Invoice',
                                'RECEIPT' => 'Receipt',
                            ])
                            ->required()
                            ->disabled(fn (string $operation): bool => $operation === 'edit')
                            ->live(),
                        Forms\Components\TextInput::make('doc_no')
                            ->disabled()
                            ->visibleOn('edit')
                            ->maxLength(50),
                        Forms\Components\Select::make('status')
                            ->options([
                                'Draft' => 'Draft',
                                'Issued' => 'Issued',
                                'Paid' => 'Paid',
                                'Void' => 'Void',
                            ])
                            ->default('Draft')
                            ->required(),
                        Forms\Components\Select::make('client_id')
                            ->relationship('client', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->live(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Dates')
                    ->schema([
                        Forms\Components\DatePicker::make('doc_date')
                            ->default(now())
                            ->required(),
                        Forms\Components\DatePicker::make('due_date')
                            ->default(now()->addDays(14))
                            ->visible(fn (Forms\Get $get): bool => $get('doc_type') === 'INVOICE'),
                        Forms\Components\DatePicker::make('valid_until')
                            ->default(now()->addDays(30))
                            ->visible(fn (Forms\Get $get): bool => $get('doc_type') === 'QUOTE'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Bill To')
                    ->schema([
                        Forms\Components\TextInput::make('bill_to_name')
                            ->maxLength(255)
                            ->nullable(),
                        Forms\Components\TextInput::make('bill_to_email')
                            ->email()
                            ->maxLength(255)
                            ->nullable(),
                        Forms\Components\TextInput::make('bill_to_phone')
                            ->maxLength(50)
                            ->nullable(),
                        Forms\Components\Textarea::make('bill_to_address')
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Line Items')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('item_desc')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('qty')
                                    ->numeric()
                                    ->default(1)
                                    ->required(),
                                Forms\Components\TextInput::make('unit_price')
                                    ->numeric()
                                    ->prefix('RM')
                                    ->default(0)
                                    ->required(),
                                Forms\Components\TextInput::make('line_discount')
                                    ->numeric()
                                    ->prefix('RM')
                                    ->default(0),
                                Forms\Components\TextInput::make('line_total')
                                    ->numeric()
                                    ->prefix('RM')
                                    ->disabled(),
                            ])
                            ->orderColumn('sort_order')
                            ->columns([
                                'md' => 5,
                            ]),
                    ]),

                Forms\Components\Section::make('Financial')
                    ->schema([
                        Forms\Components\TextInput::make('subtotal')
                            ->numeric()
                            ->prefix('RM')
                            ->disabled(),
                        Forms\Components\TextInput::make('discount_amount')
                            ->numeric()
                            ->prefix('RM')
                            ->default(0),
                        Forms\Components\TextInput::make('tax_percent')
                            ->numeric()
                            ->suffix('%')
                            ->default(0),
                        Forms\Components\TextInput::make('tax_amount')
                            ->numeric()
                            ->prefix('RM')
                            ->disabled(),
                        Forms\Components\TextInput::make('grand_total')
                            ->numeric()
                            ->prefix('RM')
                            ->disabled(),
                    ])
                    ->columns(5),

                Forms\Components\Section::make('Payment (Receipt)')
                    ->schema([
                        Forms\Components\TextInput::make('paid_amount')
                            ->numeric()
                            ->prefix('RM')
                            ->default(0),
                        Forms\Components\TextInput::make('payment_method')
                            ->maxLength(255)
                            ->nullable(),
                        Forms\Components\TextInput::make('payment_ref')
                            ->maxLength(255)
                            ->nullable(),
                        Forms\Components\Select::make('related_doc_id')
                            ->relationship('relatedDocument', 'doc_no')
                            ->searchable()
                            ->nullable(),
                    ])
                    ->columns(2)
                    ->visible(fn (Forms\Get $get): bool => $get('doc_type') === 'RECEIPT'),

                Forms\Components\Section::make('Notes')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->nullable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('doc_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'QUOTE' => 'gray',
                        'INVOICE' => 'warning',
                        'RECEIPT' => 'success',
                    }),
                Tables\Columns\TextColumn::make('doc_no')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('client.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('doc_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grand_total')
                    ->money('MYR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('paid_amount')
                    ->money('MYR')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Draft' => 'gray',
                        'Issued' => 'warning',
                        'Paid' => 'success',
                        'Void' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('doc_type')
                    ->options([
                        'QUOTE' => 'Quote',
                        'INVOICE' => 'Invoice',
                        'RECEIPT' => 'Receipt',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Draft' => 'Draft',
                        'Issued' => 'Issued',
                        'Paid' => 'Paid',
                        'Void' => 'Void',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('print')
                    ->label('Print')
                    ->icon('heroicon-o-printer')
                    ->url(fn (Document $record) => route('documents.print', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('convertToInvoice')
                    ->label('Convert to Invoice')
                    ->icon('heroicon-o-arrow-right-circle')
                    ->visible(fn (Document $record) => $record->doc_type === 'QUOTE')
                    ->action(function (Document $record) {
                        $record->convertTo('INVOICE');
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Convert Quote to Invoice')
                    ->modalDescription('This will create a new Invoice based on this Quote. Continue?')
                    ->modalSubmitActionLabel('Convert'),
                Tables\Actions\Action::make('convertToReceipt')
                    ->label('Buat Resit')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Document $record) => $record->doc_type === 'INVOICE')
                    ->action(function (Document $record) {
                        $newReceipt = $record->convertTo('RECEIPT');
                        $record->update(['status' => 'Paid']);
                        return redirect()->to(route('documents.print', $newReceipt));
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Jana Resit')
                    ->modalDescription('Resit akan dijana berdasarkan invois ini. Invois asal akan ditanda "Paid". Teruskan?')
                    ->modalSubmitActionLabel('Jana Resit'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
