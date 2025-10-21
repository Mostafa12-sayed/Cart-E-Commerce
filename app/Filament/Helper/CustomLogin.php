<?php
namespace App\Filament\Helper;




use Filament\Auth\Pages\Login;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Illuminate\Contracts\Support\Htmlable;

class CustomLogin extends  Login
{
    public function getTitle(): string | Htmlable
    {
        return "Mostafa";
    }
    public function getHeading(): string | Htmlable
    {
        if (filled($this->userUndertakingMultiFactorAuthentication)) {
            return __('filament-panels::auth/pages/login.multi_factor.heading');
        }

        return __('filament-panels::auth/pages/login.heading');
    }

}
