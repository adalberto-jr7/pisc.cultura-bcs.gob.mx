<?php

namespace App\Filament\Resources\ActivityTypesResource\Pages;

use App\Filament\Resources\ActivityTypesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditActivityTypes extends EditRecord
{
    protected static string $resource = ActivityTypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
