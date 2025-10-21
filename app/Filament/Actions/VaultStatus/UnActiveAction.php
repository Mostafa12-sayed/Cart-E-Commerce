<?php

namespace App\Filament\Actions\VaultStatus;

use App\Enums\VaultStatus;
use App\Models\Vault;
use App\Models\VaultApplication;
use App\Models\VaultUser;
use App\Models\VaultUserProfileHistory;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;

class UnActiveAction
{
    public static function make(): Action
    {
        return Action::make('unactive')
            ->label(__('vault.actions.unactive'))
            ->icon(Heroicon::LockClosed)
            ->color('danger')
            ->visible(fn (Vault $record): bool => $record->vaultUser->vault_status === VaultStatus::Active)
            ->requiresConfirmation()
            ->modalHeading(__('vault.modals.close_vault'))
            ->modalDescription(__('vault.modals.close_description'))
            ->modalSubmitActionLabel(__('vault.modals.close_submit'))
            ->action(function (Vault $record) {
                $vaultUser = $record->vaultUser;
                $oldRecord = clone $vaultUser;

                $vaultUser->update([
                    'vault_status' =>VaultStatus::Inactive,
                ]);
                VaultUserProfileHistory::create([
                    'entity_id' => $vaultUser ->id,
                    'entity_type' => VaultUser::class,
                    'object_before' => $oldRecord->toArray(),
                    'object_after' => $vaultUser->toArray(),
                    'changed_by' => auth()->user()->name,
                    'changed_at'=>now(),
                    'change_reason' => null,
                ]);

                Notification::make()
                    ->title(__('vault.notifications.close_title'))
                    ->body(__('vault.notifications.close_body', ['name' => $vaultUser->name]))
                    ->success()
                    ->duration(5000)
                    ->send();
            });
    }

}
