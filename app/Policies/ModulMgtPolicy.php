<?php

namespace App\Policies;

use App\Models\ModulMgt;
use App\Models\User;

class ModulMgtPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('portal:modul_mgt:view_any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ModulMgt $modulMgt): bool
    {
        return $user->hasPermissionTo('portal:modul_mgt:view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('portal:modul_mgt:create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ModulMgt $modulMgt): bool
    {
        return $user->hasPermissionTo('portal:modul_mgt:update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ModulMgt $modulMgt): bool
    {
        return $user->hasPermissionTo('portal:modul_mgt:delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ModulMgt $modulMgt): bool
    {
        return $user->hasPermissionTo('portal:modul_mgt:restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ModulMgt $modulMgt): bool
    {
        return $user->hasPermissionTo('portal:modul_mgt:force_delete');
    }
}
