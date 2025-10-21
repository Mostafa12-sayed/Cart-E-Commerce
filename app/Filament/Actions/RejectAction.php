<?php

namespace App\Filament\Actions;

use App\Models\VaultApplication;
use App\Models\VaultUserProfileHistory;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;

class RejectAction
{
    public static function make(): Action
    {
        return Action::make('reject')
            ->label(__('vault.actions.reject'))
            ->icon(Heroicon::XMark)
            ->color('danger')
            ->visible(fn (VaultApplication $record): bool => $record->status === VaultApplication::STATUS_PENDING || $record->status === VaultApplication::STATUS_APPROVED)
            ->requiresConfirmation()
            ->modalHeading(__('vault.modals.reject_heading'))
            ->modalDescription(__('vault.modals.reject_description'))
            ->modalSubmitActionLabel(__('vault.modals.reject_submit'))
            ->form([
                Textarea::make('decision_reason')
                    ->label(__('vault.fields.rejection_reason'))
                    ->required()
                    ->maxLength(1000)
                    ->rows(4)
                    ->placeholder(__('vault.placeholders.rejection_reason')),
            ])
            ->action(function (VaultApplication $record, array $data) {
                $oldRecord = clone $record;
                $record->update([
                    'status' => VaultApplication::STATUS_REJECTED,
                    'decision_by' => auth()->user()->name,
                    'decision_at' => now(),
                    'decision_reason' => $data['decision_reason'],
                ]);

                VaultUserProfileHistory::create([
                    'entity_id' => $record->id,
                    'entity_type' => VaultApplication::class,
                    'object_before' => $oldRecord->toArray(),
                    'object_after' => $record->toArray(),
                    'changed_by' => auth()->user()->name,
                    'changed_at' => now(),
                    'change_reason' => __('vault.logs.reject_reason', ['reason' => $data['decision_reason']]),
                ]);

                Notification::make()
                    ->title(__('vault.notifications.rejected_title'))
                    ->body(__('vault.notifications.rejected_body', ['name' => $record->name]))
                    ->warning()
                    ->duration(5000)
                    ->send();
            });
    }
}
