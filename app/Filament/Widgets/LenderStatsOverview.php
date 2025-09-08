<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Offer;
use App\Models\Lender;

class LenderStatsOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = null;
    
    // Lebar penuh widget
    protected int | string | array $columnSpan = 'full';
    
    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        $lender = Lender::where('user_id',auth()->id())->first();

        // Saldo lender
        $balance = $lender->balance ?? 0;

        $totalOffers = Offer::where('lender_id', $lender->id)->count();

        $activeOffers = Offer::where('lender_id', $lender->id)
            ->whereHas('loan', fn($q) => $q->whereIn('status', ['requested','approved','active']))
            ->count();

        $monthlyIncome = Offer::where('lender_id', $lender->id)
            ->get()
            ->sum(function($offer) {
                $loan = $offer->loan;
                if (!$loan) return 0;

                // estimasi per bulan: total repayment / tenor
                return $offer->repayment_amount / max($loan->tenor, 1);
            });

        return [
            Stat::make('Saldo', 'Rp' . number_format($balance, 0, ',', '.'))
                ->description('Total saldo tersedia')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Total Penawaran', number_format($totalOffers))
                ->description('Jumlah semua penawaran')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Penawaran Aktif', number_format($activeOffers))
                ->description('Jumlah penawaran yang sedang aktif')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('warning'),

            Stat::make('Perkiraan Penghasilan Bulanan', 'Rp' . number_format($monthlyIncome, 0, ',', '.'))
                ->description('Estimasi penghasilan per bulan dari penawaran')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('info'),
        ];
    }
}
