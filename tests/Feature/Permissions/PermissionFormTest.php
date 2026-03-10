<?php

namespace Tests\Feature\Permissions;

use App\Filament\Resources\Permissions\Pages\CreatePermission;
use App\Filament\Resources\Permissions\Pages\ListPermissions;
use App\Models\ModulMgt;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PermissionFormTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create();
    }

    /**
     * Happy path: submitting structured form fields creates a permission
     * with the concatenated 'module:feature:action' name in the database.
     */
    public function test_creates_permission_with_concatenated_name(): void
    {
        ModulMgt::factory()->create([
            'module_name' => 'hris',
            'is_active' => true,
        ]);

        $this->actingAs($this->adminUser);

        Livewire::test(CreatePermission::class)
            ->fillForm([
                'module_name' => 'hris',
                'feature' => 'report',
                'action' => 'export',
                'guard_name' => 'web',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('permissions', [
            'name' => 'hris:report:export',
            'guard_name' => 'web',
        ]);
    }

    /**
     * Validation: each required field must be filled.
     */
    public function test_create_permission_fails_validation_when_required_fields_are_empty(): void
    {
        $this->actingAs($this->adminUser);

        Livewire::test(CreatePermission::class)
            ->fillForm([
                'module_name' => null,
                'feature' => null,
                'action' => null,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'module_name' => 'required',
                'feature' => 'required',
                'action' => 'required',
            ]);
    }

    /**
     * Edge case: the list page correctly displays existing permissions.
     */
    public function test_permission_list_is_accessible(): void
    {
        Permission::create(['name' => 'hris:attendance:view', 'guard_name' => 'web']);

        $this->actingAs($this->adminUser);

        Livewire::test(ListPermissions::class)
            ->assertCanSeeTableRecords(Permission::all());
    }
}
