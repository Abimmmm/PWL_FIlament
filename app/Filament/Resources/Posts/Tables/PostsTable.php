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
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Post')
                    ->weight('bold')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category.name')
                    ->sortable()
                    ->searchable(),
                ColorColumn::make('color')
                    ->label('Color')
                    ->sortable(),
                ImageColumn::make('image')
                    ->disk('public')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
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
            ])->defaultSort('title', 'desc')
            ->filters([
                Filter::make('created_at')
                    ->label('Creation Date')
                    ->schema([
                        DatePicker::make('created_at')
                            ->label('Select Date: '),
                        
                    ])
                    
                    ->query(function ($query, $data) {
                        return $query
                        ->when(
                            $data['created_at'],
                            fn ($query, $date) => $query->whereDate('created_at', $date)
                        );
                    }),
                    SelectFilter::make('category_id')
                            ->label('Select Category')
                            ->relationship('category', 'name')
                            ->preload(),    
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
