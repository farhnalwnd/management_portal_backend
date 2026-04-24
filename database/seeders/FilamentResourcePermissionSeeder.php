<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class FilamentResourcePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $guardName = 'web';

        $resourcesPortal = [
            'approval_master',
            'content_mgt',
            'menu_mgt',
            'modul_mgt',
            'role',
            'permission',
            'user',
        ];

        $resourceCatera = [
            'dashboard',
            'registered',
            'quota_scheduling',
        ];

        $actions = [
            'view_any',
            'view',
            'create',
            'update',
            'delete',
            'restore',
            'force_delete',
        ];

        $permissions = [];

        foreach ($resourcesPortal as $resource) {
            foreach ($actions as $action) {
                $permissions[] = [
                    'name' => "portal:{$resource}:{$action}",
                    'guard_name' => $guardName,
                    'module_id' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        foreach ($resourceCatera as $resource) {
            foreach ($actions as $action) {
                $permissions[] = [
                    'name' => "catera:{$resource}:{$action}",
                    'guard_name' => $guardName,
                    'module_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert or Ignore to prevent duplicates
        Permission::insertOrIgnore($permissions);
    }
}
