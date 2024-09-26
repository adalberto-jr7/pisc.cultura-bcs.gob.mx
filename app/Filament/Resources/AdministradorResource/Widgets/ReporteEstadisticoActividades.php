<?php

namespace App\Filament\Resources\AdministradorResource\Widgets;

use App\Models\ActivityType;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ReporteEstadisticoActividades extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(ActivityType::withCount('activities')->withSum('activities', 'total'))
            ->columns([
                TextColumn::make('name')
                    ->label('Tipo de actividad')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('activities_count')
                    ->label('Total de actividades'),

                TextColumn::make('activities_sum_total')
                    ->label('Total de usuarios atendidos')
                    ->formatStateUsing(fn($state) => $state ? number_format($state) : '0')
            ]);
    }
}
