<?php

namespace App\Filament\Resources\ModulMgts;

use App\Filament\Resources\ModulMgts\Pages\CreateModulMgt;
use App\Filament\Resources\ModulMgts\Pages\EditModulMgt;
use App\Filament\Resources\ModulMgts\Pages\ListModulMgts;
use App\Filament\Resources\ModulMgts\Pages\ViewModulMgt;
use App\Filament\Resources\ModulMgts\Schemas\ModulMgtForm;
use App\Filament\Resources\ModulMgts\Schemas\ModulMgtInfolist;
use App\Filament\Resources\ModulMgts\Tables\ModulMgtsTable;
use App\Models\ModulMgt;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ModulMgtResource extends Resource
{
    protected static ?string $model = ModulMgt::class;

    protected static string | UnitEnum | null $navigationGroup = 'Feature Management';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ModulMgtForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ModulMgtInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ModulMgtsTable::configure($table);
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
            'index' => ListModulMgts::route('/'),
            'create' => CreateModulMgt::route('/create'),
            'view' => ViewModulMgt::route('/{record}'),
            'edit' => EditModulMgt::route('/{record}/edit'),
        ];
    }
}
