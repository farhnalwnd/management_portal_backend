<?php

namespace App\Filament\Widgets;

use App\Models\ModulMgt;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Spatie\Permission\Models\Role;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalModules = ModulMgt::count();
        $activeModules = ModulMgt::where('is_active', true)->count();
        $activationRate = $totalModules > 0 ? round(($activeModules / $totalModules) * 100, 1) : 0;

        return [
            Stat::make('Total Users', User::count())
                ->description('Total registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('New Users (Month)', User::where('created_at', '>=', Carbon::now()->startOfMonth())->count())
                ->description('Joined this month')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('success'),

            Stat::make('Total Roles', Role::count())
                ->description('Configured system roles')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('primary'),

            Stat::make('Module Activation', "{$activationRate}%")
                ->description("{$activeModules} of {$totalModules} active")
                ->descriptionIcon('heroicon-m-cpu-chip')
                ->chart([7, 3, 4, 5, 6, 3, $activationRate / 10])
                ->color($activationRate > 80 ? 'success' : ($activationRate > 50 ? 'warning' : 'danger')),
        ];
    }
}
