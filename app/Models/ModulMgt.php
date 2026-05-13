<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class ModulMgt extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'md_modul_mgts';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('featur mgt')
            ->logAll()
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    protected $fillable = [
        'module_name',
        'slug',
        'api_secret',
        'module_description',
        'is_active',
        'category',
        'created_by',
        'last_modified_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'last_modified_by', 'id');
    }

    public function categoryRelationship(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MdModuleCategory::class, 'category');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = auth()->id();
                $model->last_modified_by = auth()->id();
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->last_modified_by = auth()->id();
            }
        });
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'module_id');
    }
}
