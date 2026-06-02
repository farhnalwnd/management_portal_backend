<?php

namespace Database\Seeders;

use App\Models\ContentMgt;
use App\Models\MenuMgt;
use App\Models\ModulMgt;
use Illuminate\Database\Seeder;

class MenuMgtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cateraModule = ModulMgt::query()->where('module_name', 'catera')->first();
        $portalModule = ModulMgt::query()->where('module_name', 'portal')->first();
        $salesModule = ModulMgt::query()->where('module_name', 'sales_connect')->first();
        $materialModule = ModulMgt::query()->where('module_name', 'material_sync')->first();
        $productionModule = ModulMgt::query()->where('module_name', 'production_planner')->first();
        $maintenanceModule = ModulMgt::query()->where('module_name', 'maintenance_tracker')->first();

        $cateraContent = ContentMgt::query()->where('type', 'catera')->first();
        $portalContent = ContentMgt::query()->where('type', 'portal')->first();

        $menus = [
            [
                'menu_name' => 'catera',
                'module_id' => $cateraModule?->id ?? 1,
                'content_id' => $cateraContent?->id ?? 1,
                'is_active' => true,
                'created_at' => '2026-04-14 02:22:13',
                'updated_at' => '2026-04-14 02:22:13',
            ],
            [
                'menu_name' => 'portal-aplication',
                'module_id' => $portalModule?->id ?? 2,
                'content_id' => $portalContent?->id ?? 2,
                'is_active' => true,
                'created_at' => '2026-04-16 14:33:49',
                'updated_at' => '2026-04-16 14:33:49',
            ],
            [
                'menu_name' => 'sales-dashboard',
                'module_id' => $salesModule?->id,
                'content_id' => $portalContent?->id ?? 1,
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_name' => 'material-inventory',
                'module_id' => $materialModule?->id,
                'content_id' => $portalContent?->id ?? 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_name' => 'production-schedule',
                'module_id' => $productionModule?->id,
                'content_id' => $portalContent?->id ?? 1,
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_name' => 'maintenance-log',
                'module_id' => $maintenanceModule?->id,
                'content_id' => $portalContent?->id ?? 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($menus as $menu) {
            MenuMgt::create($menu);
        }
    }
}
