<?php

namespace App\Filament\Widgets;

use App\Models\ModulMgt;
use Filament\Widgets\ChartWidget;

class ModuleCategoryChart extends ChartWidget
{
    protected static ?int $sort = 4;

    protected ?string $heading = 'Modules by Category';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $data = ModulMgt::query()
            ->selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Modules',
                    'data' => array_values($data),
                    'backgroundColor' => [
                        '#0891b2', // cyan-600
                        '#0e7490', // cyan-700
                        '#155e75', // cyan-800
                        '#164e63', // cyan-900
                        '#22d3ee', // cyan-400
                    ],
                    'borderColor' => '#0891b2',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
