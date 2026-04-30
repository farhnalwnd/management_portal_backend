<?php

namespace App\Policies;

use App\Models\ApprovalMaster;
use App\Models\User;

class ApprovalMasterPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // return $user->hasPermissionTo('portal:approval_master:view_any');
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ApprovalMaster $approvalMaster): bool
    {
        return $user->hasPermissionTo('portal:approval_master:view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('portal:approval_master:create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ApprovalMaster $approvalMaster): bool
    {
        return $user->hasPermissionTo('portal:approval_master:update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ApprovalMaster $approvalMaster): bool
    {
        return $user->hasPermissionTo('portal:approval_master:delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ApprovalMaster $approvalMaster): bool
    {
        return $user->hasPermissionTo('portal:approval_master:restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ApprovalMaster $approvalMaster): bool
    {
        return $user->hasPermissionTo('portal:approval_master:force_delete');
    }
}
