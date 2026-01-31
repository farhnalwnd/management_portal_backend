<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = [
            'super_admin',
            'vice_president',
            'general_manager',
            'manager',
            'assistant_manager',
            'section_head',
            'officer',
            'admin',
            'leader',
            'operator'
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        $permissions = [
            // Modul Management
            'view:modules',
            'create:modules',
            'edit:modules',
            'delete:modules',

            // Menu Management
            'view:menus',
            'create:menus',
            'edit:menus',
            'delete:menus',

            // Content Management
            'view:contents',
            'create:contents',
            'edit:contents',
            'delete:contents',
            'publish:contents',

            // Approval System
            'view:approvals',
            'approve:contents',
            'reject:contents',

            // User & Department Management
            'view:users',
            'create:users',
            'edit:users',
            'delete:users',
            'view:departments',
            'manage:departments',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $allPermissions = Permission::all();
        Role::findByName('super_admin')->givePermissionTo($allPermissions);
        Role::findByName('vice_president')->givePermissionTo($allPermissions);

        $viewOnlyPermissions = [
            'view:modules',
            'view:menus',
            'view:contents',
            'view:approvals',
            'view:users',
            'view:departments'
        ];

        $restrictedRoles = [
            'general_manager',
            'manager',
            'assistant_manager',
            'section_head',
            'officer',
            'admin',
            'leader',
            'operator'
        ];

        foreach ($restrictedRoles as $roleName) {
            Role::findByName($roleName)->givePermissionTo($viewOnlyPermissions);
        }

        $user = User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'nik' => 999999,
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'password' => bcrypt('password'),
                'department_id' => 1,
                'status' => 'active',
            ]
        );

        $user->assignRole('super_admin');

        $this->command->info('Seeding Roles, Permissions, and Super Admin user completed.');
    }
}
