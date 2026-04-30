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
            'expired_at' => now()->addMinutes(1),
        ]);
        // Log::info('value variable ssoTicket' . json_encode($ssoTicket));

        if ($ssoTicket) {
            return $token;
        }

        Log::error('token gagal di generate');

        return null;
    }
}
