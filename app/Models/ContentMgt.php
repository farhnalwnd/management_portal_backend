<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class ContentMgt extends Model
{
    use HasFactory, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('featur mgt')
            ->logAll()
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    protected $fillable = [
        'type',
        'title',
        'modul_id',
        'version',
        'status',
        'repo',
        'created_by',
        'last_modified_by',
        'published_by',
        'published_date',
        'approver_id',
        'approval_status',
    ];

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id', 'id');
    }

    public function module()
    {
        return $this->belongsTo(ModulMgt::class, 'modul_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'last_modified_by', 'id');
    }

    public function approvalMgt()
    {
        return $this->hasMany(ApprovalMgt::class, 'approver_id', 'id');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->published_by = auth()->id();
                $model->created_by = auth()->id();
                $model->last_modified_by = auth()->id();
            }

            $approver = ApprovalMaster::where('level', 1)->first();
            $model->approver_id = $approver?->approver_id;
            // $model->approval_status = 'approved';
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->last_modified_by = auth()->id();
            }
        });
    }
}
