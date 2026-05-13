<?php

namespace App\Filament\Resources\MdModuleCategories\Schemas;

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
                            ->label('Module Sign')
                            ->placeholder('e.g. fico')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('module_slug')
                            ->label('Module Slug')
                            ->placeholder('e.g. Finance & Controlling (FI/CO)')
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }
}
