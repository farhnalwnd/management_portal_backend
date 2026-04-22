<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            departmentSeeder::class,
            UserSeeder::class,
            ModulMgtSeeder::class,
            ContentMgtSeeder::class,
            MenuMgtSeeder::class,
            ApprovalMasterSeeder::class,
            FilamentResourcePermissionSeeder::class,
            RolePermissionSeeder::class,
        ]);
    }
}
