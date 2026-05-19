<?php

namespace App\Filament\Resources\Roles\Schemas;

use App\Models\MdModuleCategory;
use App\Models\ModulMgt;
use App\Models\Permission;
use Filament\Forms\Components\CheckboxList;
// use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Role Identity')
                    ->columns(4)
                    ->schema([
                        TextInput::make('name')
                            ->label('Role Name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpan(3),
                        TextInput::make('guard_name')
                            ->label('Guard')
                            ->default('web')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                    ])
                    ->columnSpanFull(),

                Section::make('Permissions Mapping')
                    ->description('Pilih hak akses yang akan diberikan pada role ini, dikelompokkan berdasarkan kategori SAP.')
                    ->schema([
                        Tabs::make('Permissions Tabs')
                            ->tabs(self::buildPermissionTabs()),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    /** @return array<Tabs\Tab> */
    private static function buildPermissionTabs(): array
    {
        $tabs = [];

        $categoryLabels = MdModuleCategory::pluck('module_slug', 'id')->toArray();

        $modulesByCategory = ModulMgt::query()->where('is_active', true)
            ->orderBy('category')
            ->orderBy('module_name')
            ->get()
            ->groupBy('category');

        foreach ($modulesByCategory as $categoryId => $modules) {
            $categoryLabel = $categoryLabels[$categoryId] ?? "Category {$categoryId}";

            $moduleSections = $modules->map(function (ModulMgt $module) {
                $modulePermissions = Permission::query()->where('module_id', $module->id)->get();

                $features = $modulePermissions->groupBy(function ($perm) {
                    $parts = explode(':', $perm->name);

                    return count($parts) >= 3 ? $parts[1] : 'General';
                });

                $featureFieldsets = $features->map(function ($perms, $featureName) use ($module) {
                    return Section::make(ucwords(str_replace('_', ' ', $featureName)))
                        ->schema([
                            CheckboxList::make('permissions_feature_'.$module->id.'_'.$featureName)
                                ->label('select permission')
                                ->options($perms->mapWithKeys(function ($p) {
                                    $parts = explode(':', $p->name);
                                    $action = count($parts) >= 3 ? $parts[2] : $p->name;

                                    return [$p->id => ucwords(str_replace('_', ' ', $action))];
                                }))
                                ->bulkToggleable()
                                ->columns(4)
                                ->gridDirection('row')
                                ->afterStateHydrated(function (CheckboxList $component, ?Model $record) use ($perms) {
                                    if ($record) {
                                        $component->state($record->permissions()->whereIn('id', $perms->pluck('id'))->pluck('id')->toArray());
                                    }
                                })
                                ->dehydrated(true),
                        ])
                        ->collapsible(true)
                        ->collapsed(true)
                        ->columns(1);
                })->values()->all();

                return Section::make(strtoupper((string) $module->module_name))
                    ->schema($featureFieldsets)
                    ->collapsible(true)
                    ->collapsed(true);
            })->values()->all();

            $tabs[] = Tabs\Tab::make($categoryLabel)
                ->schema($moduleSections);
        }

        return $tabs;
    }
}
