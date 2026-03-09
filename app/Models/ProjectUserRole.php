<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Role;

class ProjectUserRole extends Model
{
    protected $fillable = [
        'module_id',
        'user_id',
        'role_id',
    ];

    public function modulMgt(): BelongsTo
    {
        return $this->belongsTo(ModulMgt::class, 'module_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
