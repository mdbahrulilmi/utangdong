<?php

namespace App\Filament\Resources\Repayments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RepaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('loan_id')
                    ->required()
                    ->numeric(),
                TextInput::make('amount_paid')
                    ->required()
                    ->numeric(),
                TextInput::make('paid_at')
                    ->required()
                    ->numeric(),
            ]);
    }
}
