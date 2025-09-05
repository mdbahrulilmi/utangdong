<?php

namespace App\Filament\Resources\Offers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use App\Models\Loan;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Hidden;

class OfferForm
{
    public static function configure(Schema $schema, array $data = []): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                // Hidden fields
                Hidden::make('loan_id'),
                Hidden::make('lender_id'),

                // Toggle Full Funded
                Toggle::make('is_full_funded')
                    ->label('Full Funded?')
                    ->default(false)
                    ->reactive()
                    ->afterStateUpdated(fn(Get $get, Set $set) => self::updateRepayment($get, $set)),

                // Amount (hanya muncul saat partial funded)
                TextInput::make('amount')
                    ->label('Amount')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->live(onBlur: true)
                    ->hidden(fn(Get $get) => (bool)$get('is_full_funded'))
                    ->afterStateUpdated(fn(Get $get, Set $set) => self::updateRepayment($get, $set)),

                // Interest Rate
                TextInput::make('interest_rate')
                    ->label('Interest Rate (%)')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Get $get, Set $set) => self::updateRepayment($get, $set)),

                // Repayment Amount (read-only)
                TextInput::make('repayment_amount')
                    ->label('Repayment Amount')
                    ->required()
                    ->numeric()
                    ->readOnly()
                    ->reactive()
                    ->afterStateHydrated(function (TextInput $component, $state, Get $get, Set $set) {
                        self::updateRepayment($get, $set);
                    }),
            ]);
    }

    public static function updateRepayment(Get $get, Set $set): void
    {
        $loanId = $get('loan_id') ?? request()->query('loan_id');
        $loan = $loanId ? Loan::find($loanId) : null;

        if (!$loan) return;

        $isFull = $get('is_full_funded');
        $interest = (float) $get('interest_rate') ?? 0;

        if ($isFull) {
            $baseAmount = (float)$loan->amount;
        } else {
            $baseAmount = (float)$get('amount') ?? 0;
        }

        $repayment = $baseAmount + ($baseAmount * $interest / 100);
        $set('repayment_amount', round($repayment, 2));
    }
}
