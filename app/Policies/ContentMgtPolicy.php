<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ContentMgt;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContentMgtPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ContentMgt');
    }

    public function view(AuthUser $authUser, ContentMgt $contentMgt): bool
    {
        return $authUser->can('View:ContentMgt');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ContentMgt');
    }

    public function update(AuthUser $authUser, ContentMgt $contentMgt): bool
    {
        return $authUser->can('Update:ContentMgt');
    }

    public function delete(AuthUser $authUser, ContentMgt $contentMgt): bool
    {
        return $authUser->can('Delete:ContentMgt');
    }

    public function restore(AuthUser $authUser, ContentMgt $contentMgt): bool
    {
        return $authUser->can('Restore:ContentMgt');
    }

    public function forceDelete(AuthUser $authUser, ContentMgt $contentMgt): bool
    {
        return $authUser->can('ForceDelete:ContentMgt');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ContentMgt');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ContentMgt');
    }

    public function replicate(AuthUser $authUser, ContentMgt $contentMgt): bool
    {
        return $authUser->can('Replicate:ContentMgt');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ContentMgt');
    }

}