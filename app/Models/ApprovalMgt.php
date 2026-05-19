<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class ApprovalMgt extends Model
{
    use LogsActivity;

    protected $table = 'portal_application.md_approval_mgts';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    protected $fillable = [
        'approver_id',
        'menu_schedule_id',
        'approval_level',
        'token',
        'comments',
        'approval_status',
    ];

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id', 'id');
    }
}
