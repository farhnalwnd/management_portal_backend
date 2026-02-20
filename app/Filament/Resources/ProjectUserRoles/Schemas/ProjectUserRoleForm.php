<?php

namespace App\Filament\Resources\ProjectUserRoles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProjectUserRoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('module_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('role_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
