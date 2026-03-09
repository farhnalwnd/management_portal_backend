<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    /**
     * Get the module that the permission belongs to.
     */
    public function modulMgt(): BelongsTo
    {
        return $this->belongsTo(ModulMgt::class, 'module_id', 'id');
    }
}
