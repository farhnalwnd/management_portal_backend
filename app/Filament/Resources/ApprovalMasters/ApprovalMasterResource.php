<?php

namespace App\Filament\Resources\ApprovalMasters;

use App\Filament\Resources\ApprovalMasters\Pages\CreateApprovalMaster;
use App\Filament\Resources\ApprovalMasters\Pages\EditApprovalMaster;
use App\Filament\Resources\ApprovalMasters\Pages\ListApprovalMasters;
use App\Filament\Resources\ApprovalMasters\Schemas\ApprovalMasterForm;
use App\Filament\Resources\ApprovalMasters\Tables\ApprovalMastersTable;
use App\Models\ApprovalMaster;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ApprovalMasterResource extends Resource
{
    protected static ?string $model = ApprovalMaster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'ApprovalMaster';

    public static function form(Schema $schema): Schema
    {
        return ApprovalMasterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApprovalMastersTable::configure($table);
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
            'index' => ListApprovalMasters::route('/'),
            'create' => CreateApprovalMaster::route('/create'),
            'edit' => EditApprovalMaster::route('/{record}/edit'),
        ];
    }
}
