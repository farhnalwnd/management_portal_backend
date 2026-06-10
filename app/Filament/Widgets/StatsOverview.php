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

    public function getColumns(): int | array
    {
        return [
            'default' => 2,
            'lg' => 4,
        ];
    }

    protected function getStats(): array
    {
        $totalModules = \Illuminate\Support\Facades\Cache::remember('stats.total_modules', 300, function () {
            return ModulMgt::count('id');
        });

        $activeModules = \Illuminate\Support\Facades\Cache::remember('stats.active_modules', 300, function () {
            return ModulMgt::query()->where('is_active', true)->count();
        });

        $activationRate = $totalModules > 0 ? round(($activeModules / $totalModules) * 100, 1) : 0;

        $totalUsers = \Illuminate\Support\Facades\Cache::remember('stats.total_users', 300, function () {
            return User::count('id');
        });

        $newUsersThisMonth = User::query()->where('created_at', '>=', Carbon::now()->startOfMonth())->count();

        $totalRoles = \Illuminate\Support\Facades\Cache::remember('stats.total_roles', 300, function () {
            return Role::count('id');
        });

        return [
            Stat::make('Total Users', $totalUsers)
                ->description('Total registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('New Users (Month)', $newUsersThisMonth)
                ->description('Joined this month')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('success'),

            Stat::make('Total Roles', $totalRoles)
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
