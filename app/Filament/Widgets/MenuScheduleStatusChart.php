<?php

namespace App\Filament\Widgets;

use App\Models\MenuSchedule;
use Filament\Widgets\ChartWidget;

class MenuScheduleStatusChart extends ChartWidget
{
    protected static ?int $sort = 3;

    public ?string $filter = '';

    protected ?string $pollingInterval = null;

    protected static bool $isLazy = false;

    protected ?string $heading = 'Menu Schedule Status Distribution';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
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

        $statusCounts = $query->pluck('count', 'status')->toArray();

        if (empty($statusCounts) || array_sum($statusCounts) === 0) {
            return [
                'datasets' => [
                    [
                        'label' => 'No Data',
                        'data' => [1],
                        'backgroundColor' => ['#e5e7eb'],
                        'borderColor' => ['#d1d5db'],
                        'borderWidth' => 1,
                        'animation' => [
                            'duration' => 1500,
                            'easing' => 'easeOutQuart',
                            'animateRotate' => true,
                            'animateScale' => true,
                        ],
                    ],
                ],
                'labels' => ['No Data Available For This Period'],
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Schedules',
                    'data' => [
                        $statusCounts['approval_stage'] ?? 0,
                        $statusCounts['pending'] ?? 0,
                        $statusCounts['executed'] ?? 0,
                        $statusCounts['failed'] ?? 0,
                        $statusCounts['rejected'] ?? 0,
                    ],
                    'backgroundColor' => [
                        '#3b82f6',
                        '#f59e0b',
                        '#10b981',
                        '#ef4444',
                        '#6b7280',
                    ],
                    'animation' => [
                        'duration' => 1500,
                        'easing' => 'easeOutQuart',
                        'animateRotate' => true,
                        'animateScale' => true,
                    ],
                ],
            ],
            'labels' => ['Approval Stage', 'Pending', 'Executed', 'Failed', 'Rejected'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'display' => false,
                ],
            ],
        ];
    }

    protected function getFilters(): ?array
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
