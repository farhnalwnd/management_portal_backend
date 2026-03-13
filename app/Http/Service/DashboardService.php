<?php

namespace App\Http\Service;

use App\Http\Resources\Api\ContentResource;
use App\Http\Resources\Api\MenuResource;
use App\Http\Resources\Api\ModulResource;
use App\Models\MenuMgt;

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

    public function getMenu($userLogin) {}
}
