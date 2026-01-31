<?php

namespace App\Filament\Resources\ModulMgts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ModulMgtForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('module_name')
                    ->required(),
                TextInput::make('module_description')
                    ->default(null),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('category')
                    ->required(),
                TextInput::make('created_by')
                    ->required()
                    ->numeric(),
                TextInput::make('last_modified_by')
                    ->required()
                    ->numeric(),
            ]);
    }
}
