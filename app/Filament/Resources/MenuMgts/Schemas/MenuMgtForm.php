<?php

namespace App\Filament\Resources\MenuMgts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MenuMgtForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('menu_name')
                    ->required(),
                TextInput::make('module_id')
                    ->required()
                    ->numeric(),
                TextInput::make('content_id')
                    ->required()
                    ->numeric(),
                TextInput::make('display_order')
                    ->required()
                    ->numeric(),
                TextInput::make('menu_level')
                    ->required()
                    ->numeric(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
