<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SettingsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('grade')
                    ->required(),
                TextInput::make('min_score')
                    ->required()
                    ->numeric(),
                TextInput::make('max_score')
                    ->required()
                    ->numeric(),
                TextInput::make('interest_rate')
                    ->required()
                    ->numeric(),
                TextInput::make('late_fee_rate')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('max_tenor_months')
                    ->required()
                    ->numeric()
                    ->default(12),
                TextInput::make('max_loan_amount')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
