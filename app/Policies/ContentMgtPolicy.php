<?php

namespace App\Policies;

use App\Models\ContentMgt;
use App\Models\User;

class ContentMgtPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('portal:content_mgt:view_any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContentMgt $contentMgt): bool
    {
        return $user->hasPermissionTo('portal:content_mgt:view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('portal:content_mgt:create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContentMgt $contentMgt): bool
    {
        return $user->hasPermissionTo('portal:content_mgt:update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContentMgt $contentMgt): bool
    {
        return $user->hasPermissionTo('portal:content_mgt:delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContentMgt $contentMgt): bool
    {
        return $user->hasPermissionTo('portal:content_mgt:restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContentMgt $contentMgt): bool
    {
        return $user->hasPermissionTo('portal:content_mgt:force_delete');
    }
}
