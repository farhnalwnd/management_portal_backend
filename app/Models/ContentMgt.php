<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentMgt extends Model
{
    use HasFactory;

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
        'approval_status',];
}
