<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class MdModuleCategory extends Model
{
    use LogsActivity;

    protected $table = 'portal_application.md_module_categories';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('featur mgt')
            ->logAll()
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    protected $fillable = [
        'module_sign',
        'module_slug',
        'color',
        'icon',
    ];

    public function modulMgts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ModulMgt::class, 'category');
    }
}
