<?php

namespace App\Filament\Resources\AdministradorResource\Widgets;

use App\Models\ActivityType;
use Filament\Support\Enums\IconPosition;
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
                    ->color('link')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->iconPosition(IconPosition::After)
                    ->url(fn($record) => route('filament.administrador.resources.activity-types.view', $record->id))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('activities_count')
                    ->sortable()
                    ->label('Total de actividades'),

                TextColumn::make('activities_sum_total')
                    ->label('Total de usuarios atendidos')
                    ->sortable(),
            ]);
    }
}
