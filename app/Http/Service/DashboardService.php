<?php

namespace App\Http\Service;

use App\Http\Resources\Api\MenuResource;
use App\Models\MenuMgt;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardService
{
    public function getMenu(User $userLogin)
    {
        $roleIds = $userLogin->roles->pluck('id');

        $moduleIds = DB::table('role_has_permissions')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->whereIn('role_has_permissions.role_id', $roleIds)
            ->distinct()
            ->pluck('permissions.module_id')
            ->filter()
            ->values()
            ->toArray();

        $accsessibleMenus = MenuMgt::with(['modul_mgt', 'content_mgt'])
            ->whereIn('module_id', $moduleIds)
            ->where('is_active', true)
            ->orderBy('display_order', 'asc')
            ->get();

        $menus = MenuResource::collection($accsessibleMenus);

        return $menus->resolve();
    }
}
