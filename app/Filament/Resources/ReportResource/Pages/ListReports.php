<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('Todos'),
            'Pendiente' => Tab::make()->query(fn($query) => $query->where('status_id', 3)),
            'Concluido' => Tab::make()->query(fn($query) => $query->where('status_id', 2)),
            'En curso' => Tab::make()->query(fn($query) => $query->where('status_id', 1))
        ];
    }
}
