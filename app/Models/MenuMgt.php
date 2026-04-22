<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class MenuMgt extends Model
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

    protected $table = 'menu_mgts';

    protected $fillable = [
        'menu_name',
        'module_id',
        'content_id',
        'display_order',
        'menu_level',
        'is_active',
    ];

    public function modul_mgt()
    {
        return $this->belongsTo(ModulMgt::class, 'module_id', 'id');
    }

    public function content_mgt()
    {
        return $this->belongsTo(ContentMgt::class, 'content_id', 'id');
    }
}
