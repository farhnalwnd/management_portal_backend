<?php

namespace App\Filament\Widgets;

use App\Models\ContentMgt;
use Filament\Widgets\ChartWidget;

class ContentApprovalChart extends ChartWidget
{
    protected static ?int $sort = 4;

    protected ?string $heading = 'Content Approval Status';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $data = ContentMgt::query()
            ->selectRaw('approval_status, count(*) as count')
            ->groupBy('approval_status')
            ->pluck('count', 'approval_status')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Contents',
                    'data' => [
                        $data['pending'] ?? 0,
                        $data['approved'] ?? 0,
                        $data['rejected'] ?? 0,
                    ],
                    'backgroundColor' => [
                        '#f59e0b', // amber-500
                        '#10b981', // green-500
                        '#ef4444', // red-500
                    ],
                ],
            ],
            'labels' => ['Pending', 'Approved', 'Rejected'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
