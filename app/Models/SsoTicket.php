<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SsoTicket extends Model
{
    protected $table = 'portal_application.sso_tickets';

    protected $fillable = [
        'user_id',
        'ticket',
        'expired_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
