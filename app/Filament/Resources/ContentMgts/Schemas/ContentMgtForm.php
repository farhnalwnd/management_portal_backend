<?php

namespace App\Filament\Resources\ContentMgts\Schemas;

use App\Models\ApprovalMaster;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
                    Grid::make(2)
                        ->schema([
                            TextInput::make('title')
                                ->label('Title')
                                ->required()
                                ->columnSpan(2),
                            TextInput::make('type')
                                ->label('Type')
                                ->required(),
                            TextInput::make('version')
                                ->label('Version')
                                ->required(),
                            TextInput::make('repo')
                                ->label('Repository URL')
                                ->url()
                                ->suffixIcon('heroicon-m-link')
                                ->placeholder('https://github.com/...')
                                ->required()
                                ->columnSpan(2),
                        ]),
                ])
                ->columnSpan(2),

                // ! perbaiki approver di select
                Section::make('Status & Scheduling')
                    ->schema([
                        Select::make('approver_id')
                            ->options(
                                User::whereHas('approvalMasters', fn($query) => $query->where('level', 1))
                                    ->get()
                                    ->pluck('first_name', 'id')
                            )
                            ->disabled()
                            ->default(fn() => ApprovalMaster::where('level', 1)->value('approver_id'))
                            ->dehydrated(),
                        Select::make('approver_id')
                            ->options(User::whereHas('approvalMasters')->pluck('first_name', 'id'))
                            ->label('Approver')
                            ->required(),
                        Select::make('approval_status')
                            ->label('Approval Status')
                            ->required(),
                        DatePicker::make('published_date')
                            ->label('Published Date')
                            ->nullable(),
                    ])->columnSpan(1),
        ]);
    }
}
