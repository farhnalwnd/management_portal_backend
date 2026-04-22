<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('access control')
            ->logAll()
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    /**
     * Get the module that the permission belongs to.
     */
    public function modulMgt(): BelongsTo
    {
        return $this->belongsTo(ModulMgt::class, 'module_id', 'id');
    }
}
