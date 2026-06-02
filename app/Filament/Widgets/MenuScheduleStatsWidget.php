<?php

namespace App\Filament\Widgets;

use App\Models\MenuSchedule;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MenuScheduleStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Schedules', MenuSchedule::count('id'))
                ->description('Total menus scheduled')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('primary'),

            Stat::make('Pending', MenuSchedule::query()->where('status', 'pending')->count())
                ->description('Waiting for execution')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Executed', MenuSchedule::query()->where('status', 'executed')->count())
                ->description('Successfully executed')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Failed', MenuSchedule::query()->where('status', 'failed')->count())
                ->description('Execution failed')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
