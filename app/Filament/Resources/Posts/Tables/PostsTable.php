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
                TextColumn::make('id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Judul Post')
                    ->weight('bold')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('category.name')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                ColorColumn::make('color')
                    ->label('Color')
                    ->toggleable()
                    ->sortable(),
                ImageColumn::make('image')
                    ->disk('public')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('tags')
                    ->label('Tags')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->searchable(),
                IconColumn::make('published')
                    ->boolean()
                    ->toggleable()
                    ->label('Published')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                TextColumn::make('published')
                    ->badge()
                    ->toggleable()
                    ->label('Status')
                    ->getStateUsing(fn ($record): string => $record->published ? 'Published' : 'Draft')
                    ->color(fn (string $state): string => match ($state) {
                        'Published' => 'success', // Hijau
                        'Draft' => 'danger',     // Merah
                        default => 'gray',
                    }),
            ])->defaultSort('created_at', 'asc')
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
