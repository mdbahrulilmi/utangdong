<?php

namespace App\Filament\Resources\Offers;

use App\Filament\Resources\Offers\Pages\CreateOffer;
use App\Filament\Resources\Offers\Pages\EditOffer;
use App\Filament\Resources\Offers\Pages\ListOffers;
use App\Filament\Resources\Offers\Schemas\OfferForm;
use App\Filament\Resources\Offers\Tables\OffersTable;
use App\Models\Offer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'offer';

    protected static ?int $navigationSort = 3;

    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'lender';
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        
        if (auth()->user()->lender) {
            $query->where('lender_id', auth()->user()->lender->id);
        }
        
        return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return OfferForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OffersTable::configure($table);
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
            'index' => ListOffers::route('/')
        ];
    }
}
