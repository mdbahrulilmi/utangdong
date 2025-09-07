<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', 1500)
                ->description('Jumlah semua user terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Total Loans', 320)
                ->description('Pinjaman tercatat di sistem')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),

            Stat::make('Active Lenders', 75)
                ->description('Lender yang masih aktif')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning'),
        ];
    }
}
