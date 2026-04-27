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
            ->columns(2)
            ->components([
                Section::make('Menu Name')
                    ->schema([
                        TextInput::make('menu_name')
                            ->hiddenLabel()
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columnSpanFull(),
                Section::make('relations')
                    ->schema([
                        Select::make('module_id')
                            ->label('Modul')
                            ->options(ModulMgt::query()->pluck('module_name', 'id'))
                            ->searchable()
                            ->required(),
                        Select::make('content_id')
                            ->label('Content')
                            ->options(ContentMgt::query()->where('status', true)->pluck('title', 'id'))
                            ->searchable()
                            ->required(),
                    ]),
                Section::make('settings')
                    ->schema([
                        TextInput::make('display_order')
                            ->required()
                            ->unique(table: 'menu_mgts', column: 'display_order', ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'The display order has already been taken.',
                            ])
                            ->numeric(),
                        TextInput::make('menu_level')
                            ->required()
                            ->unique(table: 'menu_mgts', column: 'menu_level', ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'The menu level has already been taken.',
                            ])
                            ->numeric(),
                        Toggle::make('is_active')
                            ->helperText('Enable to activate the menu.')
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark')
                            ->onColor('success')
                            ->required(),
                    ]),
            ]);
    }
}
