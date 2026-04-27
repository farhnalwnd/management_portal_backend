<?php

namespace App\Filament\Resources\Permissions\Schemas;

use App\Models\ModulMgt;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Permission Name')
                    ->columnSpan(2)
                    ->schema([
                        Grid::make(5)
                            ->schema([
                                Select::make('module_name')
                                    ->label('Module')
                                    ->options(ModulMgt::where('is_active', true)->pluck('module_name', 'module_name'))
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->columnSpan(2),
                                TextInput::make('feature')
                                    ->label('Feature')
                                    ->placeholder('contoh: report')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(2),
                                TextInput::make('action')
                                    ->label('Action')
                                    ->placeholder('contoh: view, export')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                            ]),
                    ]),

                Section::make('Assignment Details')
                    ->schema([
                        Select::make('module_id')
                            ->label('Assign to Module')
                            ->options(ModulMgt::where('is_active', true)->pluck('module_name', 'id'))
                            ->searchable()
                            ->preload()
                            ->helperText('Kosongkan jika Global Permission'),
                        TextInput::make('guard_name')
                            ->label('Guard')
                            ->default('web')
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }
}
