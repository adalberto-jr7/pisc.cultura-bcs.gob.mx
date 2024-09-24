<?php

namespace App\Filament\App\Widgets;

use Filament\Widgets\Widget;

class AreaWidget extends Widget
{
    protected int|string|array $columnSpan = 'full';

    protected static string $view = 'filament.app.widgets.area-widget';
}
