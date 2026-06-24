<?php

namespace App\Filament\Resources\RentalReceiptResource\Pages;

use App\Filament\Resources\RentalReceiptResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRentalReceipts extends ListRecords
{
    protected static string $resource = RentalReceiptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
