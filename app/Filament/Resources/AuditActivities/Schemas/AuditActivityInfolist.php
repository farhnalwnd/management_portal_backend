<?php

namespace App\Filament\Resources\AuditActivities\Schemas;

use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AuditActivityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Activity Details')
                    ->columns(2)
                    ->components([
                        TextEntry::make('log_name')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'user management' => 'info',
                                'featur mgt' => 'warning',
                                'access control' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('event')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'created' => 'success',
                                'updated' => 'warning',
                                'deleted' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('subject_type')
                            ->label('Model')
                            ->formatStateUsing(fn (string $state): string => str_replace('App\\Models\\', '', $state)),
                        TextEntry::make('subject_id')
                            ->label('Model ID'),
                        TextEntry::make('causer.name')
                            ->label('User')
                            ->placeholder('System'),
                        TextEntry::make('created_at')
                            ->dateTime(),
                    ]),

                Grid::make(2)
                    ->components([
                        Section::make('New Data')
                            ->visible(fn ($record) => isset($record->attribute_changes['attributes']))
                            ->components([
                                KeyValueEntry::make('attribute_changes.attributes')
                                    ->label(''),
                            ])
                            ->columnSpan(fn ($record) => isset($record->attribute_changes['old']) ? 1 : 2),

                        Section::make('Old Data')
                            ->visible(fn ($record) => isset($record->attribute_changes['old']))
                            ->components([
                                KeyValueEntry::make('attribute_changes.old')
                                    ->label(''),
                            ])
                            ->columnSpan(fn ($record) => isset($record->attribute_changes['attributes']) ? 1 : 2),
                    ]),
            ]);
    }
}
