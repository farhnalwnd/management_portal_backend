<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Service\AuthService;
use App\Http\Service\DashboardService;
use App\Traits\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $resultUser = $this->dashboardService->getMenu();

        return $this->success($resultUser, 'Dashboard data retrieved successfully');
    }
}
