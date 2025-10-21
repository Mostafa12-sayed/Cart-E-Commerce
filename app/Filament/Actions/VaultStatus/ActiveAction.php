<?php

namespace App\Filament\Actions\VaultStatus;

use App\Enums\VaultStatus;
use App\Models\Vault;
use App\Models\VaultApplication;
use App\Models\VaultUser;
use App\Models\VaultUserProfileHistory;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;

class ActiveAction
{
    public static function make(): Action
    {
        return Action::make('active')
            ->label(__('vault.actions.active'))
            ->icon(Heroicon::LockOpen)
            ->color('success')
            ->visible(fn (Vault $record): bool => $record->vaultUser->vault_status === VaultStatus::Inactive)
            ->requiresConfirmation()
            ->modalHeading(__('vault.modals.open_vault'))
            ->modalDescription(__('vault.modals.open_description'))
            ->modalSubmitActionLabel(__('vault.modals.open_submit'))
            ->action(function (Vault $record) {
                $vaultUser = $record->vaultUser;
                $oldRecord = clone $vaultUser;
                $vaultUser->update([
                    'vault_status' =>VaultStatus::Active,
                ]);
                VaultUserProfileHistory::create([
                    'entity_id' => $record->id,
                    'entity_type' => VaultUser::class,
                    'object_before' => $oldRecord->toArray(),
                    'object_after' => $vaultUser->toArray(),
                    'changed_by' => auth()->user()->name,
                    'changed_at'=>now(),
                    'change_reason' => null,
                ]);

                Notification::make()
                    ->title(__('vault.notifications.open_title'))
                    ->body(__('vault.notifications.open_body', ['name' => $record->name]))
                    ->success()
                    ->duration(5000)
                    ->send();
            });
    }
}
