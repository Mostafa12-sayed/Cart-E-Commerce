<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('Customer Name')
                    ->numeric(),
                TextEntry::make('transaction_id')
                ->label('Payment Transaction ID'),
                TextEntry::make('total')
                    ->numeric()
                    ->prefix('$'),
                TextEntry::make('created_at')
                    ->label('Order Date')
                    ->dateTime(),
//                TextEntry::make('updated_at')
//                    ->dateTime(),

                RepeatableEntry::make('products')
                    ->label('Order Items')
                    ->schema([
                        ImageEntry::make('image')
                            ->label('Product Image')
                            ->imageHeight(50)
                            ->imageWidth(50)
                            ->visibility('public')
                            ->defaultImageUrl(fn ($record) => asset('storage/' . $record->image))
                        ,
                        TextEntry::make('name')
                            ->label('Product Name'),

                        TextEntry::make('pivot.quantity')
                            ->label('Quantity'),

                        TextEntry::make('price')
                            ->prefix('$')
                            ->label('Price'),
                    ])
                    ->columns(4)
                    ->columnSpanFull()
                ,


            ]);
    }
}
