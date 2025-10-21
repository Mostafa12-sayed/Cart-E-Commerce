<?php

namespace App\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Pages\Page;
use Filament\Panel;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Icons\Heroicon;
use Filament\View\PanelsIconAlias;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected string $view = 'filament.pages.dashboard';


    protected static bool $shouldRegisterNavigation = true;

//    public static function getRoutePath(Panel $panel): string
//    {
//        return url('/');
//    }



}
