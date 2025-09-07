<?php

namespace App\Filament\Resources\Loans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LoanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([

                Section::make('Loan Information')
                    ->schema([
                        TextEntry::make('amount')->numeric(),
                        TextEntry::make('tenor')->numeric(),
                        TextEntry::make('interest_rate')->numeric(),
                        TextEntry::make('purpose'),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'requested'   => 'warning',
                                'approve'   => 'info',
                                'rejected'  => 'danger',
                                'active'    => 'success',
                                'completed' => 'gray',
                            }),
                        TextEntry::make('created_at')->dateTime(),
                        TextEntry::make('updated_at')->dateTime(),
                    ])
                    ->columns(2),

                Section::make('User Information')
                    ->schema([
                        TextEntry::make('user.name')->label('Name'),
                        TextEntry::make('user.email')->label('Email'),
                        TextEntry::make('user.username')->label('Username'),
                        TextEntry::make('user.status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'unverified' => 'gray',
                                'request'    => 'warning',
                                'verified'   => 'success',
                                'rejected'   => 'danger',
                            }),
                        TextEntry::make('user.created_at')->label('Registered At')->dateTime(),
                    ])
                    ->columns(2),

                Section::make('Loan History')
                    ->schema([
                        RepeatableEntry::make('offers')
                            ->label('History of Offers')
                            ->schema([
                                TextEntry::make('created_at')->label('Date')->dateTime(),
                                TextEntry::make('offer.lender_id')->label('Lender / Company'),
                                TextEntry::make('amount_offer')->label('Amount Offer')->numeric(),
                                TextEntry::make('status_offer')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'pending'  => 'warning',
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                    }),
                                TextEntry::make('reason_offer')->label('Reason')->placeholder('—'),
                            ])
                            ->columns(5)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
