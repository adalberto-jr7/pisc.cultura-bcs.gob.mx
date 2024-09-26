<?php

namespace App\Filament\Widgets;

use App\Models\ActivityType;
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

    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => true,
            ],
        ],
    ];

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
                    'label' => 'Numero de actividades',
                    'data' => $activityCounts,
                    'order' => 1,
                ],
                [
                    'label' => 'Numero de asistentes',
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
