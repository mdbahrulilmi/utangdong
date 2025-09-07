<?php

namespace App\Filament\Resources\Loans;

use App\Filament\Resources\Loans\Pages\ListLoans;
use App\Filament\Resources\Loans\Pages\ViewLoan;
use App\Filament\Resources\Loans\Schemas\LoanForm;
use App\Filament\Resources\Loans\Schemas\LoanInfolist;
use App\Filament\Resources\Loans\Tables\LoansTable;
use App\Models\Loan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentCurrencyDollar;

    protected static ?string $recordTitleAttribute = 'loan';

    protected static ?int $navigationSort = 2;

    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'lender';
    }

    public static function form(Schema $schema): Schema
    {
        return LoanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LoanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LoansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLoans::route('/'),
            'view' => ViewLoan::route('/{record}'),
        ];
    }
}
