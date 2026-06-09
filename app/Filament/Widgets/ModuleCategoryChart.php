<?php

namespace App\Filament\Widgets;

use App\Models\ModulMgt;
use Filament\Widgets\ChartWidget;

class ModuleCategoryChart extends ChartWidget
{
    protected static ?int $sort = 4;

    protected ?string $pollingInterval = null;

    protected static bool $isLazy = false;

    protected ?string $heading = 'Modules by Category';

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '350px';

    protected function getData(): array
    {
        $data = ModulMgt::query()
            // Melakukan join ke tabel categories (sesuaikan nama tabel kategori Anda)
            ->join('portal_application.md_module_categories', 'portal_application.md_modul_mgts.category', '=', 'portal_application.md_module_categories.id')
            // Mengambil nama kategori dan menghitung jumlah modul
            ->selectRaw('portal_application.md_module_categories.module_slug as category_name, count(portal_application.md_modul_mgts.id) as count')
            // Grouping berdasarkan nama kategori agar unik
            ->groupBy('portal_application.md_module_categories.module_slug')
            // Pluck data dengan format: 'Nama Kategori' => Jumlah Modul
            ->pluck('count', 'category_name')
            ->toArray();

        return [
            'datasets' => [
                [
                    'data' => array_values($data),
                    'backgroundColor' => [
                        'rgba(8, 145, 178, 0.2)', // cyan-600
                        'rgba(14, 116, 144, 0.2)', // cyan-700
                        'rgba(21, 94, 117, 0.2)', // cyan-800
                        'rgba(22, 78, 99, 0.2)', // cyan-900
                        'rgba(34, 211, 238, 0.2)', // cyan-400
                    ],
                    'borderColor' => [
                        '#0891b2',
                        '#0e7490',
                        '#155e75',
                        '#164e63',
                        '#22d3ee',
                    ],
                    'borderWidth' => 2,
                    'animation' => [
                        'duration' => 1500,
                        'easing' => 'easeOutQuart',
                        'animateScale' => true,
                        'animateRotate' => true,
                    ],
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => true,
            'scales' => [
                'x' => [
                    'display' => false,
                    // 'ticks' => [
                    //     'maxRotation' => 45,
                    //     'minRotation' => 45,
                    // ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
        ];
    }

    // public function getExtraAttributes(): array
    // {
    //     return [
    //         'class' => 'module-category-chart',
    //     ];
    // }
}
