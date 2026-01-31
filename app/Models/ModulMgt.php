<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulMgt extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_name',
        'module_description',
        'is_active',
        'category',
        'created_by',
        'last_modified_by',
    ];
}
