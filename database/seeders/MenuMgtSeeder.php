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
        MenuMgt::factory(10)->sequence(fn($sequence) => ['display_order' => $sequence->index + 1])->sequence(fn($sequence) => ['menu_level' => $sequence->index + 1])->create();
    }
}
