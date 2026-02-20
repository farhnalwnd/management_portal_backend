<?php

namespace App\Filament\Resources\ProjectUserRoles;

use App\Filament\Resources\ProjectUserRoles\Pages\CreateProjectUserRole;
use App\Filament\Resources\ProjectUserRoles\Pages\EditProjectUserRole;
use App\Filament\Resources\ProjectUserRoles\Pages\ListProjectUserRoles;
use App\Filament\Resources\ProjectUserRoles\Schemas\ProjectUserRoleForm;
use App\Filament\Resources\ProjectUserRoles\Tables\ProjectUserRolesTable;
use App\Models\ProjectUserRole;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProjectUserRoleResource extends Resource
{
    protected static ?string $model = ProjectUserRole::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'ProjectUserRole';

    public static function form(Schema $schema): Schema
    {
        return ProjectUserRoleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProjectUserRolesTable::configure($table);
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
            'index' => ListProjectUserRoles::route('/'),
            'create' => CreateProjectUserRole::route('/create'),
            'edit' => EditProjectUserRole::route('/{record}/edit'),
        ];
    }
}
