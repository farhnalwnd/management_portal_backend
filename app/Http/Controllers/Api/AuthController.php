<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Service\AuthService;
use App\Traits\Api\ApiResponse;
use App\Traits\Api\SsoTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    use ApiResponse, SsoTicket;

    public function __construct(
        protected AuthService $authService
    ) {}

    public function login(AuthRequest $request)
    {
        try{
            $validateData = $request->validated();

            $result = $this->authService->login($validateData);

            $cookie = $result['cookie'];
            
            unset($result['cookie']);

            return $this->success($result, 'Login success')->withCookie($cookie);

        } catch(\Exception $e){

            return $this->error($e->getMessage(), $e->getMessage(), 401);

        }
    }

    public function generateTicket(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return $this->error('Unauthenticated', 'Unauthenticated', 401);
        }

        $ticket = $this->generateSsoTicket($user);
        if (!$ticket) {
            return $this->error('Failed to generate ticket', 'Ticket generation failed', 500);
        }

        return $this->success(['ticket' => $ticket], 'Ticket generated successfully');
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if (!$user) {
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
    }
}
