<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Product Tabs')
                    ->tabs([
                        Tab::make('Product Details')
                            ->icon('heroicon-m-information-circle')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Product Name')
                                    ->weight('bold')
                                    ->color('primary'),

                                TextEntry::make('id')
                                    ->label('Product ID'),

                                TextEntry::make('sku')
                                    ->label('Product SKU')
                                    ->badge()
                                    ->color('success'),

                                TextEntry::make('description')
                                    ->label('Product Description'),

                                TextEntry::make('created_at')
                                    ->label('Product Creation Date')
                                    ->date('d M Y')
                                    ->color('info'),
                            ]),
                        Tab::make('Pricing & Stock')
                            ->icon('heroicon-o-banknotes')
                            ->schema([
                                TextEntry::make('price')
                                    ->money('IDR', locale: 'id')
                                    ->label('Product Price')
                                    ->icon('heroicon-o-currency-dollar'),
                                TextEntry::make('stock')
                                    ->label('Product Stock')
                                    ->badge()
                                    ->color(fn (int $state): string => match (true) {
                                                $state <= 5 => 'danger',  
                                                $state <= 20 => 'warning', 
                                                default => 'success',      
                                            })
                                    ->icon('heroicon-o-archive-box'),
                            ]),
                        Tab::make('Image and Status')
                            ->icon('heroicon-o-photo')
                            ->schema([
                            ImageEntry::make('image')
                                ->label('Product Image')
                                ->visibility('public')
                                ->disk('public'),
                            TextEntry::make('price')
                                ->label('Product Price')
                                ->money('IDR', locale: 'id')
                                ->weight('bold')
                                ->color('primary')
                                ->icon('heroicon-o-currency-dollar'),
                            TextEntry::make('stock')
                                ->label('Product Stock')
                                ->weight('bold')
                                ->color('primary'),
                            IconEntry::make('is_active')
                                ->label('Is Active')
                                ->boolean(),
                            IconEntry::make('is_featured')
                                ->label('Is Featured')
                                ->boolean(),
                            ])
                    ])->columnSpanFull()
                    ->vertical(),
                // Section::make('Image and Status')
                // ->schema([
                //     ImageEntry::make('image')
                //         ->label('Product Image')
                //         ->visibility('public')
                //         ->disk('public'),
                //     TextEntry::make('price')
                //         ->label('Product Price')
                //         ->money('IDR', locale: 'id')
                //         ->weight('bold')
                //         ->color('primary')
                //         ->icon('heroicon-o-currency-dollar'),
                //     TextEntry::make('stock')
                //         ->label('Product Stock')
                //         ->weight('bold')
                //         ->color('primary'),
                //     IconEntry::make('is_active')
                //         ->label('Is Active')
                //         ->boolean(),
                //     IconEntry::make('is_featured')
                //         ->label('Is Featured')
                //         ->boolean(),
                //     ])
                // ->columnSpanFull(),
            ]);
    }
}