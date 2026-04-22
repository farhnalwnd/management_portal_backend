<?php

namespace App\Filament\Resources\ContentMgts\Schemas;

use App\Models\ApprovalMaster;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContentMgtForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Content Information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('title')
                                    ->label('Title')
                                    ->required()
                                    ->columnSpan(3),
                                TextInput::make('type')
                                    ->label('Type')
                                    ->required(),
                                TextInput::make('version')
                                    ->label('Version')
                                    ->required(),
                                Select::make('modul_id')
                                    ->label('Module')
                                    ->relationship('module', 'module_name')
                                    ->required(),
                                TextInput::make('repo')
                                    ->label('Repository URL')
                                    ->url()
                                    ->suffixIcon('heroicon-m-link')
                                    ->placeholder('https://github.com/...')
                                    ->required()
                                    ->columnSpan(3),
                            ]),
                    ])
                    ->columnSpan(2),

                // ! perbaiki approver di select
                Section::make('Status & Scheduling')
                    // ->visibleOn('edit')
                    ->schema([
                        Select::make('approver_id')
                            ->label('Approver')
                            ->relationship('approver', 'first_name')
                            ->getOptionLabelFromRecordUsing(fn($record) => $record->first_name . ' ' . $record->last_name)
                            ->visibleOn('edit')
                            ->disabled(),
                        TextInput::make('approval_status')
                            ->disabled()
                            ->dehydrated()
                            ->default('approved')
                            ->required(),
                        DatePicker::make('published_date')
                            ->label('Published Date')
                            ->nullable(),
                        Toggle::make('status')
                            ->label('Status Content')
                            ->helperText('Active content will be visible to users')
                            ->onIcon('heroicon-m-check-circle')
                            ->offIcon('heroicon-m-x-circle')
                            ->onColor('success')
                            ->offColor('danger')
                            ->visible(fn($record) => $record && $record->approval_status === 'approved'),
                    ])->columnSpan(1),
            ]);
    }
}
