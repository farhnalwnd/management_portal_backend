<?php

namespace App\Filament\Resources\Roles\Schemas;

use App\Models\ModulMgt;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class RoleForm
{
    /** @var array<string, string> */
    private const CATEGORY_LABELS = [
        'fico' => 'Finance & Controlling',
        'mm' => 'Materials Management',
        'sd' => 'Sales & Distribution',
        'pp' => 'Production Planning',
        'pm' => 'Plant Maintenance',
        'hr' => 'Human Capital Management',
    ];

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Role Identity')
                    ->columns(6)
                    ->schema([
                        TextInput::make('name')
                            ->label('Role Name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->columnSpan(3),
                        TextInput::make('guard_name')
                            ->label('Guard')
                            ->default('web')
                            ->required()
                            ->columnSpan(2),
                        Toggle::make('all_access')
                            ->label('Superior')
                            ->inline(false)
                            ->helperText('Give all access to this role')
                            ->onColor('success')
                            ->offColor('danger')
                            ->onIcon(Heroicon::OutlinedCheck)
                            ->offIcon(Heroicon::OutlinedXMark)
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

        $tabs[] = Tabs\Tab::make('Global')
            ->schema([
                CheckboxList::make('permissions_global')
                    ->label('')
                    ->relationship(
                        name: 'permissions',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn(Builder $query) => $query->whereNull('module_id'),
                    )
                    ->bulkToggleable()
                    ->columns(4)
                    ->gridDirection('row'),
            ]);

        $modulesByCategory = ModulMgt::where('is_active', true)
            ->orderBy('category')
            ->orderBy('module_name')
            ->get()
            ->groupBy('category');

        foreach ($modulesByCategory as $categoryCode => $modules) {
            $categoryLabel = self::CATEGORY_LABELS[$categoryCode] ?? strtoupper((string) $categoryCode);

            $moduleSections = $modules->map(
                fn(ModulMgt $module): Section => Section::make($module->module_name)
                    ->schema([
                        CheckboxList::make('permissions_module_' . $module->id)
                            ->label('')
                            ->relationship(
                                name: 'permissions',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn(Builder $query) => $query->where('module_id', $module->id),
                            )
                            ->bulkToggleable()
                            ->columns(4)
                            ->gridDirection('row'),
                    ])
                    ->collapsible()
            )->values()->all();

            $tabs[] = Tabs\Tab::make($categoryLabel)
                ->schema($moduleSections);
        }

        return $tabs;
    }
}
