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
        \App\Models\MdModuleCategory::create([
            'module_sign' => 'fico',
            'module_slug' => 'Finance & Controlling (FI/CO)',
        ]);

        \App\Models\MdModuleCategory::create([
            'module_sign' => 'hr',
            'module_slug' => 'Human Resources (HR)',
        ]);
    }
}
