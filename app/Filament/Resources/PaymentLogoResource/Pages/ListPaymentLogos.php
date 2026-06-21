<?php

namespace App\Filament\Resources\PaymentLogoResource\Pages;

use App\Filament\Resources\PaymentLogoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaymentLogos extends ListRecords
{
    protected static string $resource = PaymentLogoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
