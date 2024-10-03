<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use mysql_xdevapi\Schema;

class ViewReport extends ViewRecord
{
    protected static string $resource = ReportResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('project.description')
                    ->label('Proyecto'),
                Infolists\Components\TextEntry::make('area.name')
                    ->label('Área'),
                Infolists\Components\TextEntry::make('user.name')
                    ->label('Usuario'),
                Infolists\Components\TextEntry::make('status.name')
                    ->label('Estado'),

                Infolists\Components\RepeatableEntry::make('activities')
                    ->columnSpanFull()
                    ->schema([
                        Infolists\Components\TextEntry::make('activity_name')
                            ->label('Actividad'),
                        Infolists\Components\TextEntry::make('activity_goal')
                            ->label('Meta de la actividad'),
                    ]),
            ]);
    }
}
