<?php

namespace App\Filament\Resources\MenuMgts;

use App\Filament\Resources\MenuMgts\Pages\CreateMenuMgt;
use App\Filament\Resources\MenuMgts\Pages\EditMenuMgt;
use App\Filament\Resources\MenuMgts\Pages\ListMenuMgts;
use App\Filament\Resources\MenuMgts\Schemas\MenuMgtForm;
use App\Filament\Resources\MenuMgts\Tables\MenuMgtsTable;
use App\Models\MenuMgt;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MenuMgtResource extends Resource
{
    protected static ?string $model = MenuMgt::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'MenuMgt';

    public static function form(Schema $schema): Schema
    {
        return MenuMgtForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MenuMgtsTable::configure($table);
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
            'index' => ListMenuMgts::route('/'),
            'create' => CreateMenuMgt::route('/create'),
            'edit' => EditMenuMgt::route('/{record}/edit'),
        ];
    }
}
