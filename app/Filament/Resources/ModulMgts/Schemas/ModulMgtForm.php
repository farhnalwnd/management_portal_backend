<?php

namespace App\Filament\Resources\ModulMgts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ModulMgtForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Modul Mgt Data')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('module_name')
                            ->label('Module Name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                        TextInput::make('module_description')
                            ->label('Module Description')
                            ->default(null)
                            ->maxLength(255)
                            ->columnSpan(1),
                    ]),
                Section::make('Modul Mgt Settings')
                    ->columnSpan(1)
                    ->schema([
                        Select::make('category')
                            ->label('Category')
                            ->options([
                                'fico' => 'Finance & Controlling (FI/CO)',
                                'mm' => 'Materials Management (MM)',
                                'sd' => 'Sales & Distribution (SD)',
                                'pp' => 'Production Planning (PP)',
                                'pm' => 'Plant Maintenance (PM)',
                                'hr' => 'Human Capital Management (HCM)',
                            ])
                            ->native(false)
                            ->required()
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label('Is Active')
                            ->required()
                            ->helperText('Enable to activate the module.')
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark')
                            ->onColor('success')
                            ->inline(false)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
