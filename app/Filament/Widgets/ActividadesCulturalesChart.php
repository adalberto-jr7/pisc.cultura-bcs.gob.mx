<?php

namespace App\Filament\Widgets;

use App\Models\ActivityType;
use Filament\Support\RawJs;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ActividadesCulturalesChart extends ApexChartWidget
{
    //protected int|string|array $columnSpan = 'full';

    protected static ?string $chartId = 'actividadesCulturalesChart';

    protected static ?string $heading = 'Actividades Culturales';

    public ?string $filter = 'population';

    protected function getOptions(): array
    {
        $activeFilter = $this->filter;

        $data = [];
        $name = "";
        $activityTypes = ActivityType::with('activities')->get();

        switch ($activeFilter) {
            case 'population':
                $data = $activityTypes->map(function ($activityType) {
                    return $activityType->activities->sum('total');
                })->toArray();
                $name = 'Población Atendida';
                break;

            case 'activities':
                $data = $activityTypes->map(function ($activityType) {
                    return $activityType->activities->count();
                })->toArray();
                $name = 'Número de Actividades';
                break;
        }

        $labels = $activityTypes->pluck('name');

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 500,
            ],
            'series' => [
                [
                    'name' => $name,
                    'data' => $data,
                ],
            ],
            'xaxis' => [
                'categories' => $labels,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#9F2241'],
            'plotOptions' => [
                'bar' => [
                    'horizontal' => true,
                ],
            ],
        ];
    }

    protected function extraJsOptions(): ?RawJs
    {
        return RawJs::make(<<<'JS'
        {
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '14px',
                    colors: ['#fff'],
                },
                formatter: function (val) {
                    return val > 0 ? val : '';
                },
                dropShadow: {
                    enabled: true,
                    top: 1,
                    left: 1,
                    blur: 1,
                    color: '#000',
                    opacity: 0.45,
                },
            },
            tooltip: {
                x: {
                    formatter: function (val) {
                        return val + ' 2024';
                    },
                },
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    barHeight: '120%',
               },
            },
        }
        JS);
    }

    protected function getFilters(): ?array
    {
        return [
            'population' => 'Población Atendida',
            'activities' => 'Cantidad de Actividades',
        ];
    }
}
