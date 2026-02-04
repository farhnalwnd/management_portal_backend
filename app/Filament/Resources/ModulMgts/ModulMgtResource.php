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
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
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
        return $schema
            ->columns(2)
            ->components([
                // * module name
                Section::make('Module')
                ->schema([
                    TextEntry::make('module_name')
                        ->inlineLabel(true)
                        ->label('Module Name :'),
                    TextEntry::make('module_description')
                        ->label('Description :'),
                    TextEntry::make('category')
                        ->hiddenLabel()
                        ->badge(),
                ])
                ->columnSpan(1),

                Group::make()
                ->schema([
                    // * relations
                    Section::make('Relations')
                    ->schema([
                        TextEntry::make('creator.first_name')
                            ->state(fn($record): string => $record->creator ? $record->creator->first_name . ' ' . $record->creator->last_name : '')
                            ->inlineLabel(true)
                            ->label('Created By :'),
                        TextEntry::make('modifier.first_name')
                            ->state(fn($record): string => $record->modifier ? $record->modifier->first_name . ' ' . $record->modifier->last_name : '')
                            ->inlineLabel(true)
                            ->label('Modified By :'),
                        IconEntry::make('is_active')
                            ->inlineLabel(true)
                            ->label('Is Active :')
                            ->boolean(),
                    ])
                    ->columnSpan(1),

                    // * timestamps
                    Section::make('Timestamps')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created At :')
                            ->isoDateTime(),
                        TextEntry::make('updated_at')
                            ->label('Updated At :')
                            ->isoDateTime(),
                    ]),
                ])->columnSpan(1),
            ]);
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
            'edit' => EditModulMgt::route('/{record}/edit'),
            // 'view' => ViewModulMgt::route('/{record}'),
        ];
    }
}
