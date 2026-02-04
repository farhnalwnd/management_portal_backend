<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MenuMgt;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuMgtPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MenuMgt');
    }

    public function view(AuthUser $authUser, MenuMgt $menuMgt): bool
    {
        return $authUser->can('View:MenuMgt');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MenuMgt');
    }

    public function update(AuthUser $authUser, MenuMgt $menuMgt): bool
    {
        return $authUser->can('Update:MenuMgt');
    }

    public function delete(AuthUser $authUser, MenuMgt $menuMgt): bool
    {
        return $authUser->can('Delete:MenuMgt');
    }

    public function restore(AuthUser $authUser, MenuMgt $menuMgt): bool
    {
        return $authUser->can('Restore:MenuMgt');
    }

    public function forceDelete(AuthUser $authUser, MenuMgt $menuMgt): bool
    {
        return $authUser->can('ForceDelete:MenuMgt');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MenuMgt');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MenuMgt');
    }

    public function replicate(AuthUser $authUser, MenuMgt $menuMgt): bool
    {
        return $authUser->can('Replicate:MenuMgt');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MenuMgt');
    }

}