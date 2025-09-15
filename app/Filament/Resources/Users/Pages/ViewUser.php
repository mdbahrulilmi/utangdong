<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;
use Filament\Forms;
use App\Models\Verification;
use Filament\Notifications\Notification;
use App\Models\Borrower;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;
    
    protected function getHeaderActions(): array{
        return [
            Actions\Action::make('verify')
                ->label('Mark as Verified')
                ->color('success')
                ->requiresConfirmation()
                ->action(function ($record) {
                    $record->status = 'verified';
                    $record->save();

                    $gaji = $record->verification->slip_gaji;
                    if ($gaji > 10000000) {
                        $score = 100;
                    } else if ($gaji > 7000000) {
                        $score = 80;
                    } else if ($gaji > 4000000) {
                        $score = 70;
                    } else {
                        $score = 40;
                    }

                    Borrower::updateOrCreate(
                    [
                        'user_id' => $record->id,
                        'credit_score' => $score,
                    ]
                );
                    if ($record->verification) {
                        $record->verification->update([
                            'status' => 'verified',
                            'message' => 'Verifikasi berhasil.',
                        ]);
                    }
                    Notification::make()
                    ->title('Borrower telah berhasil di verifikasi')
                    ->success()
                    ->send();
                }),

            Actions\Action::make('reject')
                ->label('Reject')
                ->color('danger')
                ->action(function ($record, array $data) {
                    $record->status = 'rejected';
                    $record->save();

                    if ($record->verification) {
                        $record->verification->update([
                            'status' => 'rejected',
                        ]);
                    }
                    Notification::make()
                    ->title('Borrower telah ditolak')
                    ->success()
                    ->send();
                }),
        ];
    }
}
