<?php

namespace App\Filament\Resources\MdModuleCategories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MdModuleCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Category Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('module_sign')
                            ->label('Category Sign')
                            ->placeholder('e.g. fico')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50),
                        TextInput::make('module_slug')
                            ->label('Category Name')
                            ->placeholder('e.g. Finance & Controlling (FI/CO)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50),
                        Select::make('color')
                            ->label('Color')
                            ->searchable()
                            ->options([
                                'primary' => 'Primary',
                                'secondary' => 'Secondary',
                                'success' => 'Success',
                                'danger' => 'Danger',
                                'warning' => 'Warning',
                                'info' => 'Info',
                                'gray' => 'Gray',
                            ])
                            ->default('primary')
                            ->required(),
                        Select::make('icon')
                            ->label('Icon')
                            ->options([
                                'heroicon-m-cube' => 'Cube',
                                'heroicon-m-document' => 'Document',
                                'heroicon-m-cog' => 'Cog',
                                'heroicon-m-users' => 'Users',
                                'heroicon-m-briefcase' => 'Briefcase',
                                'heroicon-m-banknotes' => 'Banknotes',
                                'heroicon-m-shopping-cart' => 'Shopping Cart',
                                'heroicon-m-truck' => 'Truck',
                                'heroicon-m-wrench' => 'Wrench',
                                'heroicon-m-academic-cap' => 'Academic Cap',
                                'heroicon-m-building-office' => 'Building',
                                'heroicon-m-chart-bar' => 'Chart',
                                'heroicon-m-clipboard-document-list' => 'Clipboard',
                            ])
                            ->searchable()
                            ->default('heroicon-m-cube')
                            ->required(),
                    ]),
            ]);
    }
}
