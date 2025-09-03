<?php

namespace App\Filament\Resources\Repayments\Pages;

use App\Filament\Resources\Repayments\RepaymentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRepayments extends ListRecords
{
    protected static string $resource = RepaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
