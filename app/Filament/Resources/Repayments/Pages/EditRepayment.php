<?php

namespace App\Filament\Resources\Repayments\Pages;

use App\Filament\Resources\Repayments\RepaymentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRepayment extends EditRecord
{
    protected static string $resource = RepaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
