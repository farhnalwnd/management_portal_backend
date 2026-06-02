<?php

namespace App\Http\Service;

use App\Http\Resources\Api\MenuResource;
use App\Models\MenuMgt;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getMenu(User $userLogin)
    {
        $roleIds = $userLogin->roles->pluck('id');

        $roleHasPermissionsTable = config('permission.table_names.role_has_permissions');
        $permissionsTable = config('permission.table_names.permissions');

        $moduleIds = DB::table($roleHasPermissionsTable)
            ->join($permissionsTable, "{$roleHasPermissionsTable}.permission_id", '=', "{$permissionsTable}.id")
            ->whereIn("{$roleHasPermissionsTable}.role_id", $roleIds)
            ->distinct()
            ->pluck("{$permissionsTable}.module_id")
            ->filter()
            ->values()
            ->toArray();

        $accsessibleMenus = MenuMgt::with(['modul_mgt', 'content_mgt'])
            ->whereIn('module_id', $moduleIds)
            ->where('is_active', true)
            ->get();

        $menus = MenuResource::collection($accsessibleMenus);

        return $menus->resolve();
    }
}
