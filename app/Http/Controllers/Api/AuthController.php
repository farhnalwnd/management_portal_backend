<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Service\AuthService;
use App\Traits\Api\ApiResponse;
use App\Traits\Api\SsoTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    use ApiResponse, SsoTicket;

    public function __construct(
        protected AuthService $authService
    ) {}

    public function login(AuthRequest $request)
    {
        try {
            $validateData = $request->validated();

            $result = $this->authService->login($validateData);

            $cookie = $result['cookie'];

            unset($result['cookie']);

            return $this->success($result, 'Login success')->withCookie($cookie);

        } catch (\Throwable $e) {
            Log::error('Login Error: '.$e->getMessage(), [
                'exception' => $e,
                'email' => $request->email,
            ]);

            $code = $e->getCode() && $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 401;

            return $this->error($e->getMessage(), 'Login failed', $code);
        }
    }

    public function generateTicket(Request $request)
    {
        try {
            $user = $request->user();
            if (! $user) {
                return $this->error('Unauthenticated', 'Unauthenticated', 401);
            }

            $ticket = $this->generateSsoTicket($user);
            if (! $ticket) {
                return $this->error('Failed to generate ticket', 'Ticket generation failed', 500);
            }

            return $this->success(['ticket' => $ticket], 'Ticket generated successfully');
        } catch (\Throwable $e) {
            Log::error('Generate SSO Ticket Error: '.$e->getMessage(), [
                'exception' => $e,
                'user_id' => $request->user()?->id,
            ]);

            return $this->error($e->getMessage(), 'Failed to generate ticket', 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            if (! $user) {
                return $this->error('Unauthenticated', 'Unauthenticated', 401);
            }

            if ($request->cookie('portal_access_token')) {
                /** @var \Laravel\Sanctum\PersonalAccessToken $token */
                $token = $user->currentAccessToken();
                if ($token) {
                    $token->delete();
                }
            }

            $cookie = Cookie::forget('portal_access_token')->withSameSite('none')->withSecure(true);

            return $this->success([], 'Logout success')->withCookie($cookie);
        } catch (\Throwable $e) {
            Log::error('Logout Error: '.$e->getMessage(), [
                'exception' => $e,
                'user_id' => $request->user()?->id,
            ]);

            return $this->error($e->getMessage(), 'Logout failed', 500);
        }
    }
}
