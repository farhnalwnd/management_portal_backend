<?php

namespace Database\Seeders;

use App\Models\ModulMgt;
use Illuminate\Database\Seeder;

class ModulMgtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            [
                'module_name' => 'catera',
                'module_description' => 'project catera',
                'is_active' => true,
                'category' => 'hr',
                'created_by' => 1,
                'last_modified_by' => 2,
                'deleted_at' => null,
                'created_at' => '2026-04-14 02:17:09',
                'updated_at' => '2026-04-14 02:17:09',
                'slug' => null,
                'api_secret' => null,
            ],
            [
                'module_name' => 'portal',
                'module_description' => 'portal admin panel',
                'is_active' => true,
                'category' => 'fico',
                'created_by' => 1,
                'last_modified_by' => 1,
                'deleted_at' => null,
                'created_at' => '2026-04-16 14:30:56',
                'updated_at' => '2026-04-20 09:30:57',
                'slug' => null,
                'api_secret' => null,
            ],
        ];

        foreach ($modules as $module) {
            ModulMgt::create($module);
        }
    }
}
