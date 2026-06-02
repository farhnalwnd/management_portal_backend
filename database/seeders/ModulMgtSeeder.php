<?php

namespace Database\Seeders;

use App\Models\MdModuleCategory;
use App\Models\ModulMgt;
use Illuminate\Database\Seeder;

class ModulMgtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::take(2)->get();
        $createdBy = $users->first()?->id ?? \App\Models\User::factory()->create()->id;
        $modifiedBy = ($users->count() > 1) ? $users->last()->id : \App\Models\User::factory()->create()->id;

        $modules = [
            [
                'module_name' => 'catera',
                'module_description' => 'project catera',
                'is_active' => true,
                'category' => 'hr',
                'created_by' => $createdBy,
                'last_modified_by' => $modifiedBy,
                'deleted_at' => null,
                'created_at' => '2026-04-14 02:17:09',
                'updated_at' => '2026-04-14 02:17:09',
            ],
            [
                'module_name' => 'portal',
                'module_description' => 'portal admin panel',
                'is_active' => true,
                'category' => 'fico',
                'created_by' => $createdBy,
                'last_modified_by' => $createdBy,
                'deleted_at' => null,
                'created_at' => '2026-04-16 14:30:56',
                'updated_at' => '2026-04-20 09:30:57',
            ],
            [
                'module_name' => 'sales_connect',
                'module_description' => 'SD module for sales management',
                'is_active' => false,
                'category' => 'sd',
                'created_by' => $createdBy,
                'last_modified_by' => $modifiedBy,
                'deleted_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'module_name' => 'material_sync',
                'module_description' => 'MM module for material inventory',
                'is_active' => true,
                'category' => 'mm',
                'created_by' => $createdBy,
                'last_modified_by' => $modifiedBy,
                'deleted_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'module_name' => 'production_planner',
                'module_description' => 'PP module for manufacturing',
                'is_active' => false,
                'category' => 'pp',
                'created_by' => $createdBy,
                'last_modified_by' => $createdBy,
                'deleted_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'module_name' => 'maintenance_tracker',
                'module_description' => 'PM module for plant maintenance',
                'is_active' => true,
                'category' => 'pm',
                'created_by' => $createdBy,
                'last_modified_by' => $createdBy,
                'deleted_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($modules as $module) {
            $category = MdModuleCategory::query()->where('module_sign', $module['category'])->first();
            $module['category'] = $category->id;
            ModulMgt::create($module);
        }
    }
}
