<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('username'),
                TextEntry::make('email')->label('Email address'),
                TextEntry::make('email_verified_at')->dateTime(),
                TextEntry::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'borrower'    => 'success',
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
                TextEntry::make('created_at')->dateTime(),
                TextEntry::make('updated_at')->dateTime(),

                // Verification Info
                TextEntry::make('verification.phone_number')->label('Phone Number')->placeholder('—'),
                ImageEntry::make('verification.document')->label('Document'),
                ImageEntry::make('verification.selfie')->label('Selfie'),
                TextEntry::make('verification.message')->label('Admin Message')->placeholder('—'),
            ]);
    }
}
