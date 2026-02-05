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

    public function approver(){
        return $this->belongsTo(User::class, 'approver_id', 'id');
    }

    public function module(){
        return $this->belongsTo(ModulMgt::class, 'modul_id', 'id');
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function modifier(){
        return $this->belongsTo(User::class, 'last_modified_by', 'id');
    }

    public function approvalMgt(){
        return $this->hasMany(ApprovalMgt::class, 'approver_id', 'id');
    }
}
