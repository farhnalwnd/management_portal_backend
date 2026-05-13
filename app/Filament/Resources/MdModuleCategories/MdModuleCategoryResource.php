<?php

namespace App\Filament\Resources\MdModuleCategories;

use App\Filament\Resources\MdModuleCategories\Pages\CreateMdModuleCategory;
use App\Filament\Resources\MdModuleCategories\Pages\ListMdModuleCategories;
use App\Filament\Resources\MdModuleCategories\Schemas\MdModuleCategoryForm;
use App\Filament\Resources\MdModuleCategories\Tables\MdModuleCategoriesTable;
use App\Models\MdModuleCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MdModuleCategoryResource extends Resource
{
    protected static ?string $model = MdModuleCategory::class;

    protected static ?string $modelLabel = 'Module Category';

    protected static ?string $pluralModelLabel = 'Module Categories';

    protected static string|UnitEnum|null $navigationGroup = 'Feature Management';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    public static function form(Schema $schema): Schema
    {
        return MdModuleCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MdModuleCategoriesTable::configure($table);
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
            'index' => ListMdModuleCategories::route('/'),
            'create' => CreateMdModuleCategory::route('/create'),
        ];
    }
}
