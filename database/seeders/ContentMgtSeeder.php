<?php

namespace Database\Seeders;

use App\Models\ContentMgt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentMgtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContentMgt::factory(2)->create();
    }
}
