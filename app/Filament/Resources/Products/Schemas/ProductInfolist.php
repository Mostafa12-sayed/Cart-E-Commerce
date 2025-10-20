<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('price')
                    ->money(),
                TextEntry::make('description'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('categories.name')
                ->label('categories')
                ->badge(),

                ImageEntry::make('image')
                    ->disk('public'),
                TextEntry::make('deleted_at')
                    ->dateTime(),
            ]);
    }
}
