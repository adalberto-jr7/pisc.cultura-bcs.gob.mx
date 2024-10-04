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
                        Infolists\Components\TextEntry::make('category_id')
                        ->label('Categoria'),
                        Infolists\Components\TextEntry::make('activity_goal')
                        ->label('Meta de la actividad'),
                        Infolists\Components\TextEntry::make('description')
                        ->label('Descripcion'),
                        Infolists\Components\TextEntry::make('activity_type_id')
                        ->label('Tipo de actividad'),
                        Infolists\Components\TextEntry::make('discipline_id')
                        ->label('Tipo de disciplina'),
                        Infolists\Components\TextEntry::make('author_name')
                        ->label('Nombre del autor'),
                        Infolists\Components\TextEntry::make('initial_date')
                        ->label('Fecha inicial'),
                        Infolists\Components\TextEntry::make('end_date')
                        ->label('Fecha final'),
                        Infolists\Components\TextEntry::make('name_space_held')
                        ->label('Nombre del lugar donde se realizó'),
                        Infolists\Components\TextEntry::make('municipality')
                        ->label('Municipio'),   
                        Infolists\Components\TextEntry::make('locality')
                        ->label('Localidad'),
                        
                        //Total de la poblacion atendida
                        Infolists\Components\TextEntry::make('Poblacion atendida')
                        ->label('Poblacion atendida'),
                        Infolists\Components\TextEntry::make('total')
                        ->label('Total de poblacion atendida'),
                        Infolists\Components\TextEntry::make('women_total')
                        ->label('Total de personas mujeres'),
                        Infolists\Components\TextEntry::make('men_total')
                        ->label('Total de personas hombres'),
                        Infolists\Components\TextEntry::make('children_girls')
                        ->label('Total de niñas'),
                        Infolists\Components\TextEntry::make('children_boys')
                        ->label('Total de niños'),
                        Infolists\Components\TextEntry::make('youth_women')
                        ->label('Total de jovenes mujeres'),
                        Infolists\Components\TextEntry::make('youth_men')
                        ->label('Total de jovenes hombres'),
                        Infolists\Components\TextEntry::make('adult_women')
                        ->label('Total de adultos mujeres'),
                        Infolists\Components\TextEntry::make('adult_men')
                        ->label('Total de adultos hombres'),
                        Infolists\Components\TextEntry::make('senior_women')
                        ->label('Total de personas mujeres mayores '), // revisar
                        Infolists\Components\TextEntry::make('senior_men')
                        ->label('Total de personas hombres mayores'), //revisar
                        
                        //Grupos sociales
                        Infolists\Components\TextEntry::make('Grupos sociales')
                        ->label('Grupos sociales'),
                        Infolists\Components\TextEntry::make('social_women')
                        ->label('Total de mujeres'), //revisar
                        Infolists\Components\TextEntry::make('men_total')
                        ->label('Total de hombres'),
                        Infolists\Components\TextEntry::make('social_childrens')
                        ->label('Total de niños, niñas y jóvenes'),
                        Infolists\Components\TextEntry::make('social_seniors')
                        ->label('Total de adultos mayores'),
                        Infolists\Components\TextEntry::make('social_indigenous')
                        ->label('Total de personas indígenas'),
                        Infolists\Components\TextEntry::make('social_disabled')
                        ->label('Total de personas discapacitadas'),
                        Infolists\Components\TextEntry::make('social_migrants')
                        ->label('Total de personas migrantes'),
                        Infolists\Components\TextEntry::make('social_afrodescendants')
                        ->label('Total de personas afrodescendientes'),
                        Infolists\Components\TextEntry::make('social_incarcerated')
                        ->label('Total de personas en reclusión'),
                        Infolists\Components\TextEntry::make('social_lgbtttiq')
                        ->label('Total de personas LGBTQ+'),

                            

                    ]),
            ]);
    }
}
