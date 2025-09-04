<?php

namespace App\Filament\Resources\Offers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use App\Models\Loan;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class OfferForm
{
    public static function configure(Schema $schema, array $data = []): Schema
    {
        return $schema
            ->components([
                TextInput::make('loan_id')
                    ->required()
                    ->numeric()
                    ->default(fn () => request()->query('loan_id'))
                    ->readOnly(),

                TextInput::make('lender_id')
                    ->required()
                    ->numeric()
                    ->default(fn () => auth()->id())
                    ->readOnly(),

                TextInput::make('interest_rate')
                    ->required()
                    ->numeric()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                        $loanId = $get('loan_id') ?? request()->query('loan_id');
                        $interestRate = (float) $state;

                        if ($loanId && $loan = Loan::find($loanId)) {
                            $principal = $loan->amount;
                            $totalAmount = $principal + ($principal * $interestRate / 100);
                            
                            $set('total_amount', number_format($totalAmount, 2, '.', ''));
                        }
                    }),

                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->afterStateHydrated(function (TextInput $component, $state) {
                        $loanId = request()->query('loan_id');
                        if ($loanId && $loan = Loan::find($loanId)) {
                            $component->state($loan->amount); // otomatis prefill dengan principal amount
                        }
                    })
                    ->readOnly(),
            ]);
    }
}