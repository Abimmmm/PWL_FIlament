<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;  
use Filament\Tables\Columns\IconColumn;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('slug'),
                TextColumn::make('category.name'),
                ColorColumn::make('color'),
                ImageColumn::make('image')
                    ->disk('public'),
                IconColumn::make('published')
                    ->boolean()
                    ->label('Published')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                //
                TextColumn::make('published')
                    ->badge() // Mengaktifkan fitur badge
                    ->label('Status')
                    ->getStateUsing(fn ($record): string => $record->published ? 'Published' : 'Draft')
                    ->color(fn (string $state): string => match ($state) {
                        'Published' => 'success', // Hijau
                        'Draft' => 'danger',     // Merah
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
