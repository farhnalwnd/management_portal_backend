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
                    ]),
            ]);
    }
}
