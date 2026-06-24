<?php

namespace App\Filament\Resources\RentalReceiptResource\Pages;

use App\Filament\Resources\RentalReceiptResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRentalReceipt extends EditRecord
{
    protected static string $resource = RentalReceiptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
