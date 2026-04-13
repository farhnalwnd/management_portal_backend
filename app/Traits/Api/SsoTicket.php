<?php

namespace App\Traits\Api;

use App\Models\SsoTicket as SsoTicketModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait SsoTicket
{
    public function generateSsoTicket($userLogin)
    {
        $token = Str::random(64);

        $ssoTicket = SsoTicketModel::create([
            'ticket' => $token,
            'user_id' => $userLogin->id,
            'expired_at' => now()->addMinutes(2),
        ]);

        if ($ssoTicket) {
            Log::info('token yang di generate adalah: ' . $token);
            return $token;
        }

        Log::error('token gagal di generate');
        return null;
    }
}
