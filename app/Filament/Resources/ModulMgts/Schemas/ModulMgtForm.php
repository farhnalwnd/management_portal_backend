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
            ->components([
                Section::make('Modul Mgt Details')
                ->columns(2)
                ->schema([
                    TextInput::make('module_name')
                        ->required()
                        ->columnSpanFull(),
                    TextInput::make('module_description')
                        ->default(null)
                        ->columnSpanFull(),
                    Select::make('category')
                        ->options([
                            'fico' => 'Finance & Controlling (FI/CO)',
                            'mm'   => 'Materials Management (MM)',
                            'sd'   => 'Sales & Distribution (SD)',
                            'pp'   => 'Production Planning (PP)',
                            'pm'   => 'Plant Maintenance (PM)',
                            'hr'   => 'Human Capital Management (HCM)',
                        ])
                        ->native(false)
                        ->required()
                        ->columnSpan(1),
                    Toggle::make('is_active')
                        ->required()
                        ->helperText('Enable to activate the module.')
                        ->onIcon('heroicon-m-check')
                        ->offIcon('heroicon-m-x-mark')
                        ->onColor('success')
                        ->inline(false)
                        ->columnSpan(1),
                ]),
                Section::make('Audit Information')
                ->schema([
                    Select::make('created_by')
                        ->label('Created By')
                        ->relationship('creator', 'first_name')
                        ->getOptionLabelFromRecordUsing(fn($record) => $record->first_name . ' ' . $record->last_name)
                        ->searchable(['first_name', 'last_name'])
                        ->required(),
                    Select::make('last_modified_by')
                        ->label('Last Modified By')
                        ->relationship('modifier', 'first_name')
                        ->getOptionLabelFromRecordUsing(fn($record) => $record->first_name . ' ' . $record->last_name)
                        ->searchable(['first_name', 'last_name'])
                        ->required(),
                ]),
            ]);
    }
}
