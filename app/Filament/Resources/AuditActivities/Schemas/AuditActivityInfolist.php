<?php

namespace App\Filament\Resources\AuditActivities\Schemas;

use Filament\Infolists\Components\TextEntry;
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
                            ->badge(),
                        TextEntry::make('description'),
                        TextEntry::make('subject_type')
                            ->label('Model'),
                        TextEntry::make('subject_id')
                            ->label('Model ID'),
                        TextEntry::make('causer.name')
                            ->label('User')
                            ->placeholder('System'),
                        TextEntry::make('created_at')
                            ->dateTime(),
                    ]),
                Section::make('Properties')
                    ->components([
                        TextEntry::make('attribute_changes')
                            ->label('Attribute Changes')
                            ->formatStateUsing(fn ($state) => json_encode($state, JSON_PRETTY_PRINT)),
                    ]),
            ]);
    }
}
