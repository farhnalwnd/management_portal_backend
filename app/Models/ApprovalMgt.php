<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalMgt extends Model
{
    protected $fillable = [
        'approver_id',
        'content_id',
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
