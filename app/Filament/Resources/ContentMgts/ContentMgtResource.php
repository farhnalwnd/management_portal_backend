<?php

namespace App\Filament\Resources\ContentMgts;

use App\Filament\Resources\ContentMgts\Pages\CreateContentMgt;
use App\Filament\Resources\ContentMgts\Pages\EditContentMgt;
use App\Filament\Resources\ContentMgts\Pages\ListContentMgts;
use App\Filament\Resources\ContentMgts\Pages\ViewContentMgt;
use App\Filament\Resources\ContentMgts\Schemas\ContentMgtForm;
use App\Filament\Resources\ContentMgts\Schemas\ContentMgtInfolist;
use App\Filament\Resources\ContentMgts\Tables\ContentMgtsTable;
use App\Models\ContentMgt;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContentMgtResource extends Resource
{
    protected static ?string $model = ContentMgt::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ContentMgtForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ContentMgtInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContentMgtsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContentMgts::route('/'),
            'create' => CreateContentMgt::route('/create'),
            'view' => ViewContentMgt::route('/{record}'),
            'edit' => EditContentMgt::route('/{record}/edit'),
        ];
    }
}
