<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ModulMgt;
use Illuminate\Auth\Access\HandlesAuthorization;

class ModulMgtPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ModulMgt');
    }

    public function view(AuthUser $authUser, ModulMgt $modulMgt): bool
    {
        return $authUser->can('View:ModulMgt');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ModulMgt');
    }

    public function update(AuthUser $authUser, ModulMgt $modulMgt): bool
    {
        return $authUser->can('Update:ModulMgt');
    }

    public function delete(AuthUser $authUser, ModulMgt $modulMgt): bool
    {
        return $authUser->can('Delete:ModulMgt');
    }

    public function restore(AuthUser $authUser, ModulMgt $modulMgt): bool
    {
        return $authUser->can('Restore:ModulMgt');
    }

    public function forceDelete(AuthUser $authUser, ModulMgt $modulMgt): bool
    {
        return $authUser->can('ForceDelete:ModulMgt');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ModulMgt');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ModulMgt');
    }

    public function replicate(AuthUser $authUser, ModulMgt $modulMgt): bool
    {
        return $authUser->can('Replicate:ModulMgt');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ModulMgt');
    }

}