<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;

class UserStatusChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $pollingInterval = null;

    protected static bool $isLazy = false;

    protected ?string $heading = 'User Status Distribution';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $data = User::query()
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

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
}
