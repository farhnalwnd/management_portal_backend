<?php

namespace App\Filament\Resources\MenuMgts;

use App\Filament\Resources\MenuMgts\Pages\CreateMenuMgt;
use App\Filament\Resources\MenuMgts\Pages\EditMenuMgt;
use App\Filament\Resources\MenuMgts\Pages\ListMenuMgts;
use App\Filament\Resources\MenuMgts\Schemas\MenuMgtForm;
use App\Filament\Resources\MenuMgts\Tables\MenuMgtsTable;
use App\Models\MenuMgt;
use BackedEnum;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Column;
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

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                // * menu name
                Section::make('Menu Name')
                ->schema([
                    TextEntry::make('menu_name')
                        ->hiddenLabel(),
                ])
                ->columnSpanFull(),

                // * relations
                Section::make('relations')
                ->schema([
                    TextEntry::make('modul_mgt.module_name')
                        ->label('Module :'),
                    TextEntry::make('content_mgt.title')
                        ->label('Content :'),
                ])
                ->extraAttributes(['class' => 'h-full'])
                ->columnSpan(2),

                Group::make()->schema([
                // * settings
                Section::make('settings')
                ->schema([
                    TextEntry::make('display_order')
                        ->label('Display Order :'),
                    IconEntry::make('is_active')
                        ->label('Is Active :')
                        ->boolean(),
                ])
                ->extraAttributes(['class' => 'h-full'])
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
                ])->columnSpan(1),
            ]),
            ]);
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
