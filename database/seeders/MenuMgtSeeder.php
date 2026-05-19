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
        ];

        foreach ($menus as $menu) {
            MenuMgt::create($menu);
        }
    }
}
