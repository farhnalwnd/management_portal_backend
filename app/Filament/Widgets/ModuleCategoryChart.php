<?php

namespace App\Filament\Widgets;

use App\Models\ModulMgt;
use Filament\Widgets\ChartWidget;

class ModuleCategoryChart extends ChartWidget
{
    protected static ?int $sort = 5;

    protected ?string $heading = 'Modules by Category';

    protected int|string|array $columnSpan = 'full';

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
                    'backgroundColor' => '#0891b2', // cyan-600
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
