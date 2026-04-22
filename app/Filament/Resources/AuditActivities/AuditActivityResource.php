<?php

namespace App\Filament\Resources\AuditActivities;

use App\Filament\Resources\AuditActivities\Pages\ListAuditActivities;
use App\Filament\Resources\AuditActivities\Pages\ViewAuditActivity;
use App\Filament\Resources\AuditActivities\Schemas\AuditActivityForm;
use App\Filament\Resources\AuditActivities\Schemas\AuditActivityInfolist;
use App\Filament\Resources\AuditActivities\Tables\AuditActivitiesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;
use UnitEnum;

class AuditActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|UnitEnum|null $navigationGroup = 'Access Control';

    protected static ?string $navigationLabel = 'Audit Activity';

    protected static ?string $pluralModelLabel = 'Audit Activity';

    public static function form(Schema $schema): Schema
    {
        return AuditActivityForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AuditActivityInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AuditActivitiesTable::configure($table);
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
            'index' => ListAuditActivities::route('/'),
            'view' => ViewAuditActivity::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canUpdate(): bool
    {
        return false;
    }
}
