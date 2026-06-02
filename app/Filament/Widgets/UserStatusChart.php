<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;

class UserStatusChart extends ChartWidget
{
    protected static ?int $sort = 3;

    public ?string $filter = '';

    protected ?string $pollingInterval = null;

    protected static bool $isLazy = false;

    protected ?string $heading = 'User Status Distribution';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        $query = User::query()
            ->selectRaw('status, count(*) as count')
            ->groupBy('status');

        match ($activeFilter) {
            'today' => $query->whereDate('updated_at', now()->today()),
            'week' => $query->where('updated_at', '>=', now()->subWeek()),
            'month' => $query->where('updated_at', '>=', now()->subMonth()),
            'year' => $query->where('updated_at', '>=', now()->startOfYear()),
            default => $query,
        };

        $data = $query->pluck('count', 'status')->toArray();

        if (empty($data) || array_sum($data) === 0) {
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
                    'label' => 'Users',
                    'data' => [
                        $data['active'] ?? 0,
                        $data['inactive'] ?? 0,
                        $data['locked'] ?? 0,
                    ],
                    'backgroundColor' => [
                        '#10b981', // green-500
                        '#f59e0b', // amber-500
                        '#ef4444', // red-500
                    ],
                    'animation' => [
                        'duration' => 1500,
                        'easing' => 'easeOutQuart',
                        'animateRotate' => true,
                        'animateScale' => true,
                    ],
                ],
            ],
            'labels' => ['Active', 'Inactive', 'Locked'],
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
