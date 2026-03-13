<?php

namespace App\Http\Service;

use App\Http\Resources\Api\ContentResource;
use App\Http\Resources\Api\MenuResource;
use App\Http\Resources\Api\ModulResource;
use App\Models\MenuMgt;
use Illuminate\Support\Facades\Log;

class DashboardService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    // public function getMenu()
    // {
    //     $menus = MenuMgt::with(['modul_mgt', 'content_mgt'])
    //         ->where('is_active', true)
    //         ->orderBy('display_order', 'asc')
    //         ->get();

    //     $resource = MenuResource::collection($menus)->resolve();

    //     return collect($resource)->groupBy(function ($item) {
    //         return $item['module']['category'] ?? 'Uncategorized';
    //     });
    // }

    public function getMenu($userLogin)
    {
        $roleIds = $userLogin->roles->pluck('id');

        $moduleIds = \Illuminate\Support\Facades\DB::table('role_has_permissions')
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

        // Log::info('menu yang dapat diakses adalah: ' . $accsessibleMenus);
        return MenuResource::collection($accsessibleMenus)->resolve();
    }
}
