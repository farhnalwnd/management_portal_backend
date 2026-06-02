<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MdModuleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'module_sign' => 'fico',
                'module_slug' => 'Finance & Controlling (FI/CO)',
                'color' => 'success',
                'icon' => 'heroicon-m-banknotes',
            ],
            [
                'module_sign' => 'hr',
                'module_slug' => 'Human Resources (HR)',
                'color' => 'secondary',
                'icon' => 'heroicon-m-users',
            ],
            [
                'module_sign' => 'sd',
                'module_slug' => 'Sales & Distribution (SD)',
                'color' => 'info',
                'icon' => 'heroicon-m-shopping-cart',
            ],
            [
                'module_sign' => 'mm',
                'module_slug' => 'Materials Management (MM)',
                'color' => 'warning',
                'icon' => 'heroicon-m-cube',
            ],
            [
                'module_sign' => 'pp',
                'module_slug' => 'Production Planning (PP)',
                'color' => 'primary',
                'icon' => 'heroicon-m-wrench-screwdriver',
            ],
            [
                'module_sign' => 'pm',
                'module_slug' => 'Plant Maintenance (PM)',
                'color' => 'danger',
                'icon' => 'heroicon-m-cog-6-tooth',
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\MdModuleCategory::firstOrCreate(
                ['module_sign' => $category['module_sign']],
                $category
            );
        }
    }
}
