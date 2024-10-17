<?php

namespace App\Filament\App\Resources\ReportResource\Pages;

use App\Filament\App\Resources\ReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReport extends EditRecord
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('Salir')
            ->icon('heroicon-o-chevron-left')
            ->url(route('filament.app.resources.reports.index'))

        ];
    }
}
