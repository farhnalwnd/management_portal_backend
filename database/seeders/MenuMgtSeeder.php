<?php

namespace Database\Seeders;

use App\Models\MenuMgt;
use Illuminate\Database\Seeder;

class MenuMgtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'id' => 1,
                'menu_name' => 'catera',
                'module_id' => 1,
                'content_id' => 1,
                'display_order' => 1,
                'menu_level' => 1,
                'is_active' => true,
                'created_at' => '2026-04-14 02:22:13',
                'updated_at' => '2026-04-14 02:22:13',
            ],
            [
                'id' => 2,
                'menu_name' => 'portal-aplication',
                'module_id' => 2,
                'content_id' => 2,
                'display_order' => 2,
                'menu_level' => 2,
                'is_active' => true,
                'created_at' => '2026-04-16 14:33:49',
                'updated_at' => '2026-04-16 14:33:49',
            ],
        ];

        foreach ($menus as $menu) {
            MenuMgt::updateOrCreate(
                ['id' => $menu['id']],
                $menu
            );
        }
    }
}
