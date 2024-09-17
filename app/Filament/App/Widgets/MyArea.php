<?php

namespace App\Filament\App\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class MyArea extends BaseWidget
{
    protected function getStats(): array
    {

        $area = Auth::user()->area->name;
    
        return [
            Stat::make('Pertenezco a', $area),
        ];
    }
}
