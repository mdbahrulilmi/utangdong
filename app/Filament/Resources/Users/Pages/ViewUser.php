<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;
use Filament\Forms;
use App\Models\Verification;

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

                    if ($record->verification) {
                        $record->verification->update([
                            'status' => 'verified',
                            'message' => 'Verifikasi berhasil.',
                        ]);
                    }
                }),

            Actions\Action::make('reject')
                ->label('Reject')
                ->color('danger')
                ->form([
                    Forms\Components\Textarea::make('message')
                        ->label('Reason')
                        ->required(),
                ])
                ->action(function ($record, array $data) {
                    $record->status = 'rejected';
                    $record->save();

                    if ($record->verification) {
                        $record->verification->update([
                            'status' => 'rejected',
                            'message' => $data['message'],
                        ]);
                    }
                }),
        ];
    }
}
