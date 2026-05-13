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
            DepartmentSeeder::class,
            UserSeeder::class,
            MdModuleCategorySeeder::class,
            ModulMgtSeeder::class,
            ContentMgtSeeder::class,
            MenuMgtSeeder::class,
            ApprovalMasterSeeder::class,
            FilamentResourcePermissionSeeder::class,
            RolePermissionSeeder::class,
        ]);
    }
}
