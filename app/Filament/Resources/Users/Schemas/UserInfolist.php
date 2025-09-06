<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([

                Section::make('User Information')
                    ->schema([
                        TextEntry::make('name')->label('Full Name'),
                        TextEntry::make('username'),
                        TextEntry::make('email')->label('Email Address'),
                        TextEntry::make('role')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'admin'    => 'danger',
                                'borrower' => 'success',
                                'lender'   => 'warning',
                            }),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'unverified' => 'gray',
                                'request'    => 'warning',
                                'verified'   => 'success',
                                'rejected'   => 'danger',
                            }),
                    ])
                    ->columns(2),

                Section::make('Verification Information')
                    ->schema([
                        TextEntry::make('verification.phone_number')
                            ->label('Phone Number')
                            ->placeholder('—'),
                        TextEntry::make('verification.nik')->label('NIK'),
                        TextEntry::make('verification.slip_gaji')->label('Slip Gaji'),
                    ])
                    ->columns(2),

                Section::make('Timestamps')
                    ->schema([
                        TextEntry::make('created_at')->label('Registered At')->dateTime(),
                        TextEntry::make('email_verified_at')->label('Email Verified At')->dateTime(),
                        TextEntry::make('updated_at')->label('Last Updated')->dateTime(),
                    ])
                    ->columns(3),
            ]);
    }
}
