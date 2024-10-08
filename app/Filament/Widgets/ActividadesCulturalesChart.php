<?php

namespace App\Filament\Widgets;

use App\Models\ActivityType;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function Pest\Laravel\options;

class ActividadesCulturalesChart extends ChartWidget
{
    protected static ?string $heading = 'Actividades';
    protected int|string|array $columnSpan = 'full';

    protected static string $color = 'info';

    protected static ?string $maxHeight = '300px';

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<JS
        {
            plugins: {
                datalabels: {
                    display: function(context) {
                        return context.dataset.data[context.dataIndex] > 0;
                    },
                    color: 'black',
                    font: {
                        weight: 'bold'
                    }
                },
            },
        }
    JS
        );
    }

    protected function getData(): array
    {
        $activityTypes = ActivityType::with('activities')->get();
        $labels = $activityTypes->pluck('name');

        $activityCounts = $activityTypes->map(function ($activityType) {
            return $activityType->activities->count();
        })->toArray();

        $activityTotalAssistent = $activityTypes->map(function ($activityType) {
            return $activityType->activities->sum('total');
        })->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Número de actividades',
                    'data' => $activityCounts,
                    'order' => 1,
                ],
                [
                    'label' => 'Número de asistentes',
                    'data' => $activityTotalAssistent,
                    'order' => 2,
                ]
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
