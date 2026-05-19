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
        ];

        foreach ($modules as $module) {
            $category = MdModuleCategory::query()->where('module_sign', $module['category'])->first();
            $module['category'] = $category->id;
            ModulMgt::create($module);
        }
    }
}
