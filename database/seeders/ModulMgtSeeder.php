<?php

namespace Database\Seeders;

use App\Models\ModulMgt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModulMgtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModulMgt::factory(10)->create();
    }
}
