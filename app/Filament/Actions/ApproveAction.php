<?php

namespace App\Filament\Actions;

use App\Models\VaultApplication;
use App\Models\VaultUserProfileHistory;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;

class ApproveAction
{
    public static function make(): Action
    {
        return Action::make('approve')
            ->label(__('vault.actions.approve'))
            ->icon(Heroicon::Check)
            ->color('success')
            ->visible(fn (VaultApplication $record): bool => $record->status === VaultApplication::STATUS_PENDING || $record->status === VaultApplication::STATUS_REJECTED)
            ->requiresConfirmation()
            ->modalHeading(__('vault.modals.approve_heading'))
            ->modalDescription(__('vault.modals.approve_description'))
            ->modalSubmitActionLabel(__('vault.modals.approve_submit'))
            ->action(function (VaultApplication $record) {
                $oldRecord = clone $record;

                $record->update([
                    'status' => VaultApplication::STATUS_APPROVED,
                    'decision_by' => auth()->user()->name,
                    'decision_at' => now(),
                    'decision_reason' => null,
                ]);
                VaultUserProfileHistory::create([
                    'entity_id' => $record->id,
                    'entity_type' => VaultApplication::class,
                    'object_before' => $oldRecord->toArray(),
                    'object_after' => $record->toArray(),
                    'changed_by' => auth()->user()->name,
                    'change_reason' => __('vault.logs.approve_reason'),
                ]);

                Notification::make()
                    ->title(__('vault.notifications.approved_title'))
                    ->body(__('vault.notifications.approved_body', ['name' => $record->name]))
                    ->success()
                    ->duration(5000)
                    ->send();
            });
    }
}
