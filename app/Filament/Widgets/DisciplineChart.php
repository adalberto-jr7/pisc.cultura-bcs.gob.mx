<?php

namespace App\Filament\Widgets;

use App\Models\Discipline;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class DisciplineChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'disciplineChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Disciplinas';

    public ?string $filter = 'population';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $activeFilter = $this->filter;
        $datat = [];
        $name = "";
        $discipline = Discipline::with('activities')->get();

        switch ($activeFilter) {
            case 'population':
                $data = $discipline->map(function ($discipline) {
                    return $discipline->activities->sum('total');
                })->toArray();
                $name = 'Población Atendida';
                break;
            case 'activities':
                $data = $discipline->map(function ($discipline) {
                    return $discipline->activities->count();
                })->toArray();
                $name = 'Número de Actividades';
                break;
        }


        $labels = $discipline->pluck('name');

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 500,
            ],
            'series' => [
                [
                    'name' => 'Total de actividades',
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
            'colors' => ['#f59e0b'],
            'plotOptions' => [
                'bar' => [
                    'borderRadius' => 3,
                    'horizontal' => true,
                ],
            ],
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'population' => 'Población Atendida',
            'activities' => 'Cantidad de Actividades',
        ];
    }
}
