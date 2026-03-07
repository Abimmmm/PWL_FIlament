<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Heroicons;
use Filament\Schemas\Components\Group;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
       return $schema
            ->components([
                // SISI KIRI: Main Fields (2/3 Kolom)
                Group::make()
                    ->schema([
                        Section::make('Post Details')
                            ->description('Fill in the details of the post')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                // Group dalam Section untuk membagi kolom input internal
                                Group::make()
                                    ->schema([
                                        TextInput::make('title')
                                            ->rules('required | min:5')
                                            ->validationMessages([
                                                'unique' => 'The slug must be unique.',
                                                'required' => 'The slug is required.',
                                                'min' => 'harus diisi minimal :min karakter.',
                                            ]),
                                        TextInput::make('slug')
                                            ->unique()
                                            ->rules('required | min:3')
                                            ->validationMessages([
                                                'unique' => 'The slug must be unique.',
                                                'required' => 'The slug is required.',
                                                'min' => 'harus diisi minimal :min karakter.',
                                            ]),
                                        Select::make('category_id')
                                            ->relationship('category', 'name')
                                            ->preload()
                                            ->required()
                                            ->searchable(),
                                        ColorPicker::make('color'),
                                    ])->columns(2),

                                MarkdownEditor::make('content')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(2),

                // SISI KANAN: Meta & Sidebar (1/3 Kolom)
                Group::make()
                    ->schema([
                        Section::make('Image Upload')
                            ->description('Upload a featured image for the post')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                FileUpload::make('image')
                                    ->disk('public')
                                    ->required()
                                    ->directory('posts')
                                    ->image(), 
                            ]),

                        Section::make('Meta Information')
                            ->description('Additional information about the post')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                TagsInput::make('tags'),
                                Checkbox::make('published'),
                                DatePicker::make('published_at'),
                            ]),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }
}
