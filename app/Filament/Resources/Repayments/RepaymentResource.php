<?php

namespace App\Filament\Resources\Repayments;

use App\Filament\Resources\Repayments\Pages\CreateRepayment;
use App\Filament\Resources\Repayments\Pages\EditRepayment;
use App\Filament\Resources\Repayments\Pages\ListRepayments;
use App\Filament\Resources\Repayments\Schemas\RepaymentForm;
use App\Filament\Resources\Repayments\Tables\RepaymentsTable;
use App\Models\Repayment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RepaymentResource extends Resource
{
    protected static ?string $model = Repayment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CurrencyDollar;

    protected static ?string $recordTitleAttribute = 'repayment';

    protected static ?int $navigationSort = 4;

    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'lender';
    }

    public static function form(Schema $schema): Schema
    {
        return RepaymentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RepaymentsTable::configure($table);
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
            'index' => ListRepayments::route('/'),
            'create' => CreateRepayment::route('/create'),
            'edit' => EditRepayment::route('/{record}/edit'),
        ];
    }
}
