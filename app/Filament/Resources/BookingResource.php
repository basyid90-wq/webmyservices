<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;
    protected static ?string $navigationGroup = 'Booking';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Bookings';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('booking_number')->disabled(),
            Forms\Components\Select::make('room_id')->relationship('room', 'name')->disabled(),
            Forms\Components\TextInput::make('customer_name')->disabled(),
            Forms\Components\TextInput::make('customer_email')->disabled(),
            Forms\Components\TextInput::make('customer_phone')->disabled(),
            Forms\Components\DatePicker::make('check_in')->disabled(),
            Forms\Components\DatePicker::make('check_out')->disabled(),
            Forms\Components\TextInput::make('guests_adults')->disabled(),
            Forms\Components\TextInput::make('guests_kids')->disabled(),
            Forms\Components\TextInput::make('total_nights')->disabled(),
            Forms\Components\TextInput::make('total')->prefix('RM')->disabled(),
            Forms\Components\Select::make('status')->options([
                'pending' => 'Pending', 'paid' => 'Paid', 'cancelled' => 'Cancelled',
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('booking_number')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('room.name')->searchable(),
            Tables\Columns\TextColumn::make('customer_name')->searchable(),
            Tables\Columns\TextColumn::make('check_in')->date()->sortable(),
            Tables\Columns\TextColumn::make('check_out')->date()->sortable(),
            Tables\Columns\TextColumn::make('total')->money('MYR')->sortable(),
            Tables\Columns\TextColumn::make('status')->badge()->color(fn ($s) => match ($s) {
                'paid' => 'success', 'cancelled' => 'danger', default => 'warning',
            }),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ])->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
