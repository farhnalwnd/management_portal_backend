<?php

namespace App\Http\Service;

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

    public function getMenu()
    {
        $menu = MenuMgt::where('is_active', true)->get();
    }
}
