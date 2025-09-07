<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Loan;
use App\Models\Offer;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // Simple queries to avoid errors
        $totalUsers = User::count() ?? 0;
        $totalLoans = Loan::count() ?? 0;
        $totalOffers = Offer::count() ?? 0;
        
        // Simple status counts
        $pendingLoans = Loan::where('status', 'pending')->count() ?? 0;
        $approvedLoans = Loan::where('status', 'approved')->count() ?? 0;
        
        return [
            Stat::make('Total Users', $totalUsers)
                ->description('Jumlah semua user terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Total Loans', $totalLoans)
                ->description("Jumlah semua loan")
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),

            Stat::make('Total Offers', $totalOffers)
                ->description('Penawaran yang masuk')
                ->descriptionIcon('heroicon-m-hand-raised')
                ->color('warning'),
        ];
    }
}