<?php

namespace Database\Seeders;

use App\Models\MenuMgt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuMgtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MenuMgt::factory()->create([
            'menu_name' => 'Dashboard',
            'module_id' => 1,
            'content_id' => 1,
            'display_order' => 1,
            'menu_level' => 1,
            'is_active' => true,
        ]);
    }
}
