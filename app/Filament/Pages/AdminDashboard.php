<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\LenderStatsOverview;
use App\Filament\Widgets\AdminStatsOverview;
use App\Models\User;
use App\Models\Lender;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Notifications\Notification;
use BackedEnum;

class AdminDashboard extends Page
{
    protected static ?string $title = 'Dashboard';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Home;
    protected string $view = 'filament.pages.admin-dashboard';
    
    protected function getHeaderWidgets(): array
    {
        $user = User::find(auth()->id());
        if($user->role === 'lender'){
            return [
                LenderStatsOverview::class
            ];
        }
        if($user->role === 'admin'){
            return [
                AdminStatsOverview::class
            ];
        }
        
        return [];
    }

    protected function getHeaderActions(): array
    {
        $user = User::find(auth()->id());
        
        if($user->role === 'lender'){
            return [
                Action::make('topup')
                    ->label('Top Up Saldo')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->form([
                        Forms\Components\TextInput::make('amount')
                            ->label('Jumlah Top Up')
                            ->numeric()
                            ->required()
                            ->minValue(1000)
                            ->prefix('Rp')
                            ->placeholder('Masukkan jumlah top up')
                            ->helperText('Minimum top up adalah Rp 1.000'),
                    ])
                    ->action(function (array $data): void {
                        $lender = Lender::firstOrCreate(
                            ['user_id' => auth()->id()],
                            ['balance' => 0]
                        );

                        $lender->increment('balance', $data['amount']);

                        Notification::make()
                            ->title('Top Up Berhasil!')
                            ->body('Saldo berhasil ditambahkan sebesar Rp ' . number_format($data['amount'], 0, ',', '.'))
                            ->success()
                            ->send();
                            
                        // Refresh the page to update stats
                        $this->redirect($this->getUrl());
                    }),
            ];
        }
        
        return [];
    }
}