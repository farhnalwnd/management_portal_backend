<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuSchedule extends Model
{
    protected $table = 'md_menu_schedules';

    protected $fillable = [
        'menu_id',
        'approver_id',
        'action_type',
        'scheduled_at',
        'status',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(MenuMgt::class, 'menu_id');
    }

    public function approvalMaster(): BelongsTo
    {
        return $this->belongsTo(ApprovalMaster::class, 'approver_id');
    }
}
