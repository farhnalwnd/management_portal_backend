<?php

namespace App\Filament\Resources\Roles\Schemas;

use App\Models\ModulMgt;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        $modules = ModulMgt::where('is_active', true)->get();

        $moduleTabs = [];

        // Global Permissions Tab
        $moduleTabs[] = Tabs\Tab::make('Global')
            ->schema([
                CheckboxList::make('permissions_global')
                    ->label('')
                    ->relationship(
                        name: 'permissions',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->whereNull('module_id'),
                    )
                    ->bulkToggleable()
                    ->columns(3)
                    ->gridDirection('row'),
            ]);

        // Specific Module Tabs
        foreach ($modules as $module) {
            $moduleTabs[] = Tabs\Tab::make($module->module_name)
                ->schema([
                    CheckboxList::make('permissions_module_'.$module->id)
                        ->label('')
                        ->relationship(
                            name: 'permissions',
                            titleAttribute: 'name',
                            modifyQueryUsing: fn (Builder $query) => $query->where('module_id', $module->id),
                        )
                        ->bulkToggleable()
                        ->columns(3)
                        ->gridDirection('row'),
                ]);
        }

        return $schema
            ->components([
                Section::make('Role Details')
                    ->columns(1)
                    ->schema([
                        TextInput::make('name')
                            ->label('Role Name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),
                    ]),

                Section::make('Permissions')
                    ->description('Pilih hak akses yang akan diberikan pada role ini, dikelompokkan berdasarkan modul.')
                    ->schema([
                        Tabs::make('Permissions Tabs')
                            ->tabs($moduleTabs),
                    ]),
            ]);
    }
}
