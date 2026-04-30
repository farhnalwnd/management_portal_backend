<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Service\AuthService;
use App\Http\Service\DashboardService;
use App\Traits\Api\ApiResponse;

class DashboardController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected AuthService $authService,
        protected DashboardService $dashboardService
    ) {}

    public function index()
    {
        $userLogin = $this->authService->getUserLogin();

        if ($userLogin === 'user not found') {
            return $this->error('User not found', 'user not found', 401);
        }

        $resultMenu = $this->dashboardService->getMenu($userLogin);

        if (empty($resultMenu)) {
            return $this->success($resultMenu, 'Menu not found for your role');
        }

        return $this->success($resultMenu, 'Dashboard data retrieved successfully');
    }
}
