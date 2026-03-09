<?php

namespace App\Filament\Resources\Permissions\Schemas;

use App\Models\ModulMgt;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Permission Details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Permission Name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Format yang disarankan: action:resource, contoh: view:user, edit:module'),
                        Select::make('module_id')
                            ->label('Module (Optional)')
                            ->options(ModulMgt::where('is_active', true)->pluck('module_name', 'id'))
                            ->searchable()
                            ->preload()
                            ->helperText('Kosongkan jika ini adalah Global Permission'),
                        TextInput::make('guard_name')
                            ->label('Guard')
                            ->default('web')
                            ->required(),
                    ]),
            ]);
    }
}
