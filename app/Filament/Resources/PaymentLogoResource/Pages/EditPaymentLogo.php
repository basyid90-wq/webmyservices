<?php

namespace App\Filament\Resources\PaymentLogoResource\Pages;

use App\Filament\Resources\PaymentLogoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaymentLogo extends EditRecord
{
    protected static string $resource = PaymentLogoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
