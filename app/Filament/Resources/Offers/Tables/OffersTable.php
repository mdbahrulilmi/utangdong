<?php

namespace App\Filament\Resources\Offers\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OffersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('loan_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lender_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('interest_rate')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('status')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'offering' => 'warning',
                        'accepted'    => 'success',
                        'rejected'   => 'danger',
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
            ])
            ->toolbarActions([
            ]);
    }
}
