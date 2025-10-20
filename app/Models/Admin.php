<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable implements FilamentUser, HasName
{
    use Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ✅ Filament requires these methods:
    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return true; // Or apply your logic (e.g., role-based)
    }

    public function getFilamentName(): string
    {
        return $this->username;
    }
}
