<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\LenderStatsOverview;
use App\Filament\Widgets\AdminStatsOverview;
use App\Models\User;
use Filament\Support\Icons\Heroicon;
use BackedEnum;

class AdminDashboard extends Page
{
    protected static ?string $title = 'Dashboard';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Home;
    protected string $view = 'filament.pages.admin-dashboard';
    
    protected function getHeaderWidgets(): array
    {
        $user = User::find(auth()->id());
        if($user->role ==='lender'){
            return [
                LenderStatsOverview::class
            ];
        }
        if($user->role ==='admin'){
            return [
                AdminStatsOverview::class
            ];
        }
    }
}
