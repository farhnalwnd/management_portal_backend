<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ApprovalMaster;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApprovalMasterPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ApprovalMaster');
    }

    public function view(AuthUser $authUser, ApprovalMaster $approvalMaster): bool
    {
        return $authUser->can('View:ApprovalMaster');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ApprovalMaster');
    }

    public function update(AuthUser $authUser, ApprovalMaster $approvalMaster): bool
    {
        return $authUser->can('Update:ApprovalMaster');
    }

    public function delete(AuthUser $authUser, ApprovalMaster $approvalMaster): bool
    {
        return $authUser->can('Delete:ApprovalMaster');
    }

    public function restore(AuthUser $authUser, ApprovalMaster $approvalMaster): bool
    {
        return $authUser->can('Restore:ApprovalMaster');
    }

    public function forceDelete(AuthUser $authUser, ApprovalMaster $approvalMaster): bool
    {
        return $authUser->can('ForceDelete:ApprovalMaster');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ApprovalMaster');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ApprovalMaster');
    }

    public function replicate(AuthUser $authUser, ApprovalMaster $approvalMaster): bool
    {
        return $authUser->can('Replicate:ApprovalMaster');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ApprovalMaster');
    }

}