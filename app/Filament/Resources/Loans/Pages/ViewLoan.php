<?php

namespace App\Filament\Resources\Loans\Pages;

use App\Filament\Resources\Loans\LoanResource;
use App\Filament\Resources\Offers\OfferResource;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;

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
            ->modalHeading('Create Offer')
            ->form([
                \Filament\Forms\Components\Hidden::make('loan_id')
                    ->default($this->record->id),

                \Filament\Forms\Components\TextInput::make('amount')
                    ->label('Amount')
                    ->required()
                    ->numeric(),
            ])
            ->action(function (array $data) {
                $loan = $this->record;

                $lender = \App\Models\Lender::where('user_id', auth()->id())->first();

                if ($lender->balance < $data['amount']) {
                    Notification::make()
                        ->title('Saldo Anda tidak cukup untuk membuat offer ini.')
                        ->danger()
                        ->send();
                    return;
                }

                $repayment = $data['amount'] + ($data['amount'] * ($loan->interest_rate / 100) * ($loan->tenor / 12));

                \App\Models\Offer::create([
                    'loan_id' => $loan->id,
                    'lender_id' => $lender->id,
                    'amount' => $data['amount'],
                    'repayment_amount' => $repayment,
                    'status' => 'pending',
                ]);

                $lender->update([
                    'balance' => $lender->balance - $data['amount']
                ]);

                 Notification::make()
                    ->title('Penawaran telah berhasil dibuat')
                    ->success() 
                    ->send();
                return;
            })
            ->modalWidth('md'),

        ];
}

}
