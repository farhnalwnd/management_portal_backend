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

        // $this->command->call('shield:generate');

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

        $allPermissions = Permission::all();
        Role::findByName('super_admin')->givePermissionTo($allPermissions);
        Role::findByName('vice_president')->givePermissionTo($allPermissions);

        $restrictedRoles = [
            'general_manager',
            'manager',
            'assistant_manager',
            'section_head',
        ];

        foreach ($restrictedRoles as $roleName) {
            Role::findByName($roleName)->givePermissionTo([
                'View:ContentMgt',
                'View:ModulMgt',
                // 'view:MenuMgt',
                // 'view:UserMgt',
            ]);
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

    }
}
