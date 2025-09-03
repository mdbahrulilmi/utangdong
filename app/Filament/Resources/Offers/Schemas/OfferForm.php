<?php

namespace App\Filament\Resources\Offers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OfferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('loan_id')
                    ->required()
                    ->numeric(),
                TextInput::make('lender_id')
                    ->required()
                    ->numeric(),
                TextInput::make('interest_rate')
                    ->required()
                    ->numeric(),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric(),
            ]);
    }
}
