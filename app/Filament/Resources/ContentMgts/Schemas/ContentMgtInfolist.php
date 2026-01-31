<?php

namespace App\Filament\Resources\ContentMgts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ContentMgtInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('type'),
                TextEntry::make('title'),
                TextEntry::make('modul_id')
                    ->numeric(),
                TextEntry::make('version'),
                TextEntry::make('status'),
                TextEntry::make('repo'),
                TextEntry::make('created_by')
                    ->numeric(),
                TextEntry::make('last_modified_by')
                    ->numeric(),
                TextEntry::make('published_by')
                    ->numeric(),
                TextEntry::make('published_date')
                    ->date(),
                TextEntry::make('approver_id')
                    ->numeric(),
                TextEntry::make('approval_status')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
