<?php

namespace App\Filament\Resources\Permissions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PermissionInfolist
{
    /** @var array<string, string> */
    private const CATEGORY_LABELS = [
        'fico' => 'Finance & Controlling',
        'mm' => 'Materials Management',
        'sd' => 'Sales & Distribution',
        'pp' => 'Production Planning',
        'pm' => 'Plant Maintenance',
        'hr' => 'Human Capital Management',
    ];

    /** @var array<string, string> */
    private const CATEGORY_ICONS = [
        'fico' => 'heroicon-m-banknotes',
        'mm' => 'heroicon-m-cube',
        'sd' => 'heroicon-m-shopping-cart',
        'pp' => 'heroicon-m-cog',
        'pm' => 'heroicon-m-wrench',
        'hr' => 'heroicon-m-user-group',
    ];

    /** @var array<string, string> */
    private const CATEGORY_COLORS = [
        'fico' => 'success',
        'mm' => 'warning',
        'sd' => 'info',
        'pp' => 'danger',
        'pm' => 'gray',
        'hr' => 'primary',
    ];

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Permission Details')
                    ->columnSpan(1)
                    ->schema([
                        TextEntry::make('name:')
                            ->label('Permission Name')
                            ->inlineLabel(true)
                            ->copyable(),
                        TextEntry::make('modulMgt.module_name')
                            ->label('Module:')
                            ->inlineLabel(true)
                            ->placeholder('Global'),
                        TextEntry::make('guard_name')
                            ->label('Guard:')
                            ->inlineLabel(true)
                            ->badge(),
                    ]),

                Group::make()
                    ->schema([
                        Section::make('Timestamps')
                            ->columnSpan(1)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->inlineLabel(true)
                                    ->since()
                                    ->placeholder('-')
                            ]),

                        Section::make('SAP Category')
                            ->columnSpan(1)
                            ->schema([
                                TextEntry::make('modulMgt.category')
                                    ->label('SAP Category')
                                    ->inlineLabel(true)
                                    ->default('nan')
                                    ->icon(fn(?string $state): string => self::CATEGORY_ICONS[$state ?? ''] ?? 'heroicon-m-cog-6-tooth')
                                    ->color(fn(?string $state): string => self::CATEGORY_COLORS[$state ?? ''] ?? 'gray')
                                    ->formatStateUsing(fn(?string $state): string => self::CATEGORY_LABELS[$state ?? ''] ?? 'portal system')
                                    ->badge(),
                            ]),
                    ]),
            ]);
    }
}
