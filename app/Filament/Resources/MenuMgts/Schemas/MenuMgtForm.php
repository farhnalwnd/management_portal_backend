<?php

namespace App\Filament\Resources\MenuMgts\Schemas;

use App\Models\ContentMgt;
use App\Models\ModulMgt;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MenuMgtForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(5)
            ->components([
                Section::make('Menu Name')
                    ->schema([
                        TextInput::make('menu_name')
                            ->label('Menu Name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                    ])
                    ->columnSpan(2),
                Section::make('Relations')
                    ->columns(2)
                    ->schema([
                        Select::make('module_id')
                            ->label('Module')
                            ->options(ModulMgt::query()->pluck('module_name', 'id'))
                            ->searchable()
                            ->required(),
                        Select::make('content_id')
                            ->label('Content')
                            ->options(ContentMgt::query()->where('status', true)->pluck('title', 'id'))
                            ->searchable()
                            ->required(),
                    ])
                    ->columnSpan(2),
                Section::make('Settings')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Is Active')
                            ->helperText('Enable to activate the menu.')
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark')
                            ->onColor('success')
                            ->required(),
                    ])
                    ->columnSpan(1),
            ]);
    }
}
