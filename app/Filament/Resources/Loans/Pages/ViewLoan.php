<?php

namespace App\Filament\Resources\Loans\Pages;

use App\Filament\Resources\Loans\LoanResource;
use App\Filament\Resources\Offers\OfferResource;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewLoan extends ViewRecord
{
    protected static string $resource = LoanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('createOffer')
                ->label('Create Offer')
                ->color('success')
                ->icon('heroicon-o-currency-dollar')
                ->url(fn () => OfferResource::getUrl('create', [
                    'loan_id' => $this->record->id,
                ])),
        ];
    }
}
