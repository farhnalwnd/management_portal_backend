<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\Http\Service\AuthService;
use App\Http\Service\DashboardService;
use App\Traits\Api\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected AuthService $authService,
        protected DashboardService $dashboardService
    ) {}

    public function index(): JsonResponse
    {
        try {
            $userLogin = $this->authService->getUserLogin();

            if (! $userLogin) {
                return $this->error('User not found', 'user not found', 401);
            }

            $resultMenu = $this->dashboardService->getMenu($userLogin);

            if (empty($resultMenu)) {
                return $this->success($resultMenu, 'Menu not found for your role');
            }

            return $this->success($resultMenu, 'Dashboard data retrieved successfully');
        } catch (\Throwable $e) {
            Log::error('Dashboard Index Error: '.$e->getMessage(), [
                'exception' => $e,
            ]);

            return $this->error($e->getMessage(), 'Failed to retrieve dashboard data', 500);
        }
    }

    public function me(): JsonResponse
    {
        try {
            $userLogin = $this->authService->getUserLogin();

            if (! $userLogin) {
                return $this->error('User not found', 'user not found', 401);
            }

            return $this->success(new UserResource($userLogin), 'User data retrieved successfully');
        } catch (\Throwable $e) {
            Log::error('Dashboard Me Error: '.$e->getMessage(), [
                'exception' => $e,
            ]);

            return $this->error($e->getMessage(), 'Failed to retrieve user data', 500);
        }
    }
}
