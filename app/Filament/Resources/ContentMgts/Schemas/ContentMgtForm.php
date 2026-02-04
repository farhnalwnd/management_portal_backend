<?php

namespace App\Filament\Resources\ContentMgts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContentMgtForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('type')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('modul_id')
                    ->required()
                    ->numeric(),
                TextInput::make('version')
                    ->required(),
                TextInput::make('status')
                    ->required(),
                TextInput::make('repo')
                    ->prefix('https://')
                    ->required(),
                TextInput::make('created_by')
                    ->required()
                    ->numeric(),
                TextInput::make('last_modified_by')
                    ->required()
                    ->numeric(),
                TextInput::make('published_by')
                    ->required()
                    ->numeric(),
                DatePicker::make('published_date')
                    ->required(),
                TextInput::make('approver_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
