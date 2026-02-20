<?php

namespace Database\Seeders;

use App\Models\content_mgt;
use App\Models\department;
use App\Models\menu_mgt;
use App\Models\modul_mgt;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            UserSeeder::class,
            ContentMgtSeeder::class,
            ModulMgtSeeder::class,
            MenuMgtSeeder::class,
            departmentSeeder::class,
            ApprovalMasterSeeder::class,
            // RolePermissionSeeder::class,
        ]);
    }
}
