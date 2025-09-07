<?php

namespace App\Filament\Resources\Offers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
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

                TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('repayment_amount')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('loan.interest_rate')
                    ->label('Bunga (%)')
                    ->numeric()
                    ->formatStateUsing(fn($state) => number_format($state, 2))
                    ->sortable(),

                TextColumn::make('monthly_profit')
                    ->label('Keuntungan/Bulan')
                    ->getStateUsing(function ($record) {
                        $loan = $record->loan;
                        if (!$loan || $loan->tenor <= 0) return 0;
                        $profit = ($record->repayment_amount - $record->amount) / $loan->tenor;
                        return 'Rp' . number_format($profit, 0, ',', '.');
                    })
                    ->sortable(),

                TextColumn::make('remaining_tenor')
                    ->label('Sisa Tenor')
                    ->getStateUsing(function ($record) {
                        $loan = $record->loan;
                        if (!$loan) return '-';
                        // asumsi belum ada pembayaran
                        return $loan->tenor . ' bulan';
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
