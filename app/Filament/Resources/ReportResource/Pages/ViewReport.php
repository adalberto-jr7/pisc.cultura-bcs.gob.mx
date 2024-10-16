<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Filament\Infolists\Components\Fieldset;
//
use Filament\Actions;



class ViewReport extends ViewRecord
{
    protected static string $resource = ReportResource::class;

    public function getHeaderActions(): array
    {

        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('Salir')
            ->icon('heroicon-o-chevron-left')
            ->url(url()->previous())
        ];


        return [
            Action::make('Notificar')
                ->icon('heroicon-o-exclamation-triangle')
                ->form(function ($record) {
                    return [
                        TextInput::make('title')
                            ->label('Título')
                            ->placeholder('Escribe el título de la notificación')
                            ->default($record->project->description)
                            ->required(),
                        Textarea::make('description')
                            ->label('Descripción')
                            ->placeholder('Escribe la descripción de la notificación')
                            ->required(),
                    ];
                })
                ->action(function ($record, $data) {
                    Notification::make()
                        ->title(new HtmlString('<p><strong>' . $data['title'] . '</strong><br />' . Auth::user()->name . '</p>'))
                        ->body($data['description'])
                        ->icon('heroicon-o-bell')
                        ->iconColor('danger')
                        ->actions([
                            \Filament\Notifications\Actions\Action::make('Ver reporte notificado')
                                ->url(route('filament.app.resources.reports.edit', $record->id))
                                ->button(),
                        ])
                        ->success()
                        ->duration(10)
                        ->sendToDatabase($record->user);
                    event(new DatabaseNotificationsSent($record->user));
                    $record->save();

                    Notification::make()
                        ->title('Notificación enviada')
                        ->body(new HtmlString('<p>Se ha enviado una notificación a <strong>' . $record->user->name . '</strong></p>'))
                        ->success()
                        ->send();
                })->color('danger'),

        ];
    }

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
                    ->label('Estado')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'Pendiente' => 'heroicon-m-arrow-path',
                        'En curso' => 'heroicon-m-truck',
                        'Concluido' => 'heroicon-m-check-badge',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'Pendiente' => 'info',
                        'En curso' => 'warning',
                        'Concluido' => 'success',
                    }),
                Infolists\Components\TextEntry::make('created_at')
                    ->dateTimeTooltip()
                    ->since()
                    ->label('Fecha de creación'),
                Infolists\Components\TextEntry::make('updated_at')
                    ->dateTimeTooltip()
                    ->since()
                    ->label('Ultima actualización'),

                Infolists\Components\RepeatableEntry::make('activities')
                    ->label('Actividades')
                    ->columnSpanFull()
                    ->schema([

                        Infolists\Components\Tabs::make('Tabs')
                            ->tabs([
                                Infolists\Components\Tabs\Tab::make('Información general')
                                    ->columns([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 6,
                                    ])
                                    ->schema([
                                        // Informacion general
                                        Infolists\Components\TextEntry::make('activity_name')
                                            ->label('Actividad'),
                                        Infolists\Components\TextEntry::make('category.name')
                                            ->label('Categoría'),
                                        Infolists\Components\TextEntry::make('activity_goal')
                                            ->label('Meta de la actividad'),
                                        Infolists\Components\TextEntry::make('description')
                                            ->label('Descripción'),
                                        Infolists\Components\TextEntry::make('activity_type.name')
                                            ->label('Tipo de actividad'),
                                        Infolists\Components\TextEntry::make('discipline.name')
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
                                    ]),
                                Infolists\Components\Tabs\Tab::make('Población atendida')
                                    ->columns([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 6,
                                    ])
                                    ->schema([
                                        // Poblacion atendida
                                        Infolists\Components\TextEntry::make('total')
                                            ->label('Total de población atendida'),
                                        Infolists\Components\TextEntry::make('women_total')
                                            ->label('Total de personas mujeres'),
                                        Infolists\Components\TextEntry::make('men_total')
                                            ->label('Total de personas hombres'),
                                        Infolists\Components\TextEntry::make('children_girls')
                                            ->label('Total de niñas'),
                                        Infolists\Components\TextEntry::make('children_boys')
                                            ->label('Total de niños'),
                                        Infolists\Components\TextEntry::make('youth_women')
                                            ->label('Total de jóvenes mujeres'),
                                        Infolists\Components\TextEntry::make('youth_men')
                                            ->label('Total de jóvenes hombres'),
                                        Infolists\Components\TextEntry::make('adult_women')
                                            ->label('Total de adultos mujeres'),
                                        Infolists\Components\TextEntry::make('adult_men')
                                            ->label('Total de adultos hombres'),
                                        Infolists\Components\TextEntry::make('senior_women')
                                            ->label('Total de personas mujeres mayores '),
                                        Infolists\Components\TextEntry::make('senior_men')
                                            ->label('Total de personas hombres mayores'),
                                    ]),
                                Infolists\Components\Tabs\Tab::make('Grupos sociales')
                                    ->columns([
                                        'sm' => 2,
                                        'xl' => 3,
                                        '2xl' => 6,
                                    ])
                                    ->schema([
                                        // Grupos sociales
                                        Infolists\Components\TextEntry::make('social_women')
                                            ->label('Total de mujeres'), //revisar
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
                                    ])

                            ]),
                    ]),
            ]);
    }
}
