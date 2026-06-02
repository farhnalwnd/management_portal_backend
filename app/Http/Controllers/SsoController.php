<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SsoController extends Controller
{
    public function verify(Request $request): mixed
    {
        try {
            $token = $request->query('ticket');

            if (! $token) {
                Log::info('SSO Verify: Tiket tidak ditemukan.');

                return redirect(config('services.sso.portal_url'))->with('error', 'Tiket tidak ditemukan.');
            }

            return DB::transaction(function () use ($request, $token) {
                $ticket = DB::table('portal_application.sso_tickets')
                    ->where('ticket', $token)
                    ->where('expired_at', '>', now())
                    ->lockForUpdate()
                    ->first();

                if ($ticket) {
                    Auth::loginUsingId($ticket->user_id);
                    DB::table('portal_application.sso_tickets')->where('ticket', $token)->delete();
                    $request->session()->regenerate();

                    return redirect()->intended(route('filament.admin.pages.dashboard'));
                }

                Log::info('SSO Verify: Tiket tidak valid atau kadaluwarsa.', ['ticket' => $token]);

                return redirect(config('services.sso.portal_url'))->with('error', 'Tiket tidak valid atau kadaluwarsa.');
            });
        } catch (\Throwable $e) {
            Log::error('SSO Verify Error: '.$e->getMessage(), [
                'exception' => $e,
                'ticket' => $request->query('ticket'),
            ]);

            return redirect(config('services.sso.portal_url'))->with('error', 'Terjadi kesalahan sistem saat verifikasi.');
        }
    }
}
