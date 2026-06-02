<?php

namespace App\Filament\Widgets;

use App\Models\MenuSchedule;
use Filament\Pages\Dashboard\Concerns\HasFilters;
use Filament\Widgets\Widget;

class MenuScheduleStatsWidget extends Widget
{
    use HasFilters;

    protected string $view = 'filament.widgets.menu-schedule-stats-widget';

    public ?string $filter = '';

    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $activeFilter = $this->filter;

        $query = MenuSchedule::query()
            ->selectRaw('status, count(*) as count')
            ->whereIn('status', ['approval_stage', 'pending', 'executed', 'failed', 'rejected'])
            ->groupBy('status');

        match ($activeFilter) {
            'today' => $query->whereDate('updated_at', now()->today()),
            'week' => $query->where('updated_at', '>=', now()->subWeek()),
            'month' => $query->where('updated_at', '>=', now()->subMonth()),
            'year' => $query->where('updated_at', '>=', now()->startOfYear()),
            default => $query,
        };

        $statusCounts = $query->pluck('count', 'status');

        $approval = (int) ($statusCounts['approval_stage'] ?? 0);
        $pending = (int) ($statusCounts['pending'] ?? 0);
        $executed = (int) ($statusCounts['executed'] ?? 0);
        $failed = (int) ($statusCounts['failed'] ?? 0);
        $rejected = (int) ($statusCounts['rejected'] ?? 0);

        $total = $approval + $pending + $executed + $failed + $rejected;

        $stats = [
            [
                'label' => 'Approval Stage',
                'count' => $approval,
                'percentage' => $total > 0 ? round(($approval / $total) * 100, 1) : 0,
                'color' => 'bg-blue-500',
                'textColor' => 'text-blue-500',
            ],
            [
                'label' => 'Pending',
                'count' => $pending,
                'percentage' => $total > 0 ? round(($pending / $total) * 100, 1) : 0,
                'color' => 'bg-amber-500',
                'textColor' => 'text-amber-500',
            ],
            [
                'label' => 'Executed',
                'count' => $executed,
                'percentage' => $total > 0 ? round(($executed / $total) * 100, 1) : 0,
                'color' => 'bg-emerald-500',
                'textColor' => 'text-emerald-500',
            ],
            [
                'label' => 'Failed',
                'count' => $failed,
                'percentage' => $total > 0 ? round(($failed / $total) * 100, 1) : 0,
                'color' => 'bg-red-500',
                'textColor' => 'text-red-500',
            ],
            [
                'label' => 'Rejected',
                'count' => $rejected,
                'percentage' => $total > 0 ? round(($rejected / $total) * 100, 1) : 0,
                'color' => 'bg-gray-500',
                'textColor' => 'text-gray-500',
            ],
        ];

        return [
            'total' => $total,
            'stats' => $stats,
        ];
    }

    public function getFilters(): ?array
    {
        return [
            '' => 'All',
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }
}
