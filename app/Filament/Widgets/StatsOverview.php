<?php

namespace App\Filament\Widgets;

use App\Models\ContentMgt;
use App\Models\ModulMgt;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Total registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
            Stat::make('Active Modules', ModulMgt::where('is_active', true)->count())
                ->description('Currently active modules')
                ->descriptionIcon('heroicon-m-cpu-chip')
                ->color('success'),
            Stat::make('Pending Approvals', ContentMgt::where('approval_status', 'pending')->count())
                ->description('Contents awaiting review')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
