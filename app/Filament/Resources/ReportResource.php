<?php

namespace App\Filament\Resources;

use App\Enums\MunicipalityEnum;
use App\Exports\ReportsExport;
use App\Filament\Resources\ReportResource\Pages;
use App\Imports\ActivitiesImport;
use App\Models\ActivityType;
use App\Models\Category;
use App\Models\Discipline;
use App\Models\FinnancingSource;
use App\Models\Project;
use App\Models\Report;
use App\Models\Status;
use Filament\Forms\Components\Actions\Action;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Maatwebsite\Excel\Facades\Excel;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Reportes';

    protected static ?string $label = 'Reportes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->label('Proyecto')
                    ->columnSpanFull()
                    ->required()
                    ->options(function () {
                        return Project::with('area')
                            ->get()
                            ->groupBy('area.name')
                            ->mapWithKeys(function ($projects, $area) {
                                return [$area => $projects->pluck('description', 'id')];
                            });
                    })
                    ->placeholder(fn(Forms\Get $get): string => empty($get('area_id')) ? 'Primero selecciona un proyecto' : 'Selecciona una opcion')
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $project = Project::find($state);
                        $set('area_id', $project ? $project->area->id : null);
                    }),

                Forms\Components\Select::make('area_id')
                    ->columnSpanFull()
                    ->required()
                    ->options(function (callable $get) {
                        $projectId = $get('project_id');
                        $project = Project::find($projectId);
                        return $project ? [$project->area->id => $project->area->name] : [];
                    })
                    ->label('Area')
                    ->placeholder('Seleccione un area'),
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::user()->id),
                Forms\Components\FileUpload::make('excel_file')
                    ->label('Archivo de Excel')
                    ->uploadingMessage('Subiendo actividades...')
                    //->required()
                    ->reactive()
                    ->columnSpanFull()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $rows = Excel::toArray(new ActivitiesImport(), $state);
                            $repeaterData = [];

                            foreach ($rows[0] as $row) {
                                $category = DB::table('categories')->where('name', $row[1])->select('id')->firstOrFail();
                                $activityType = DB::table('activity_types')->where('name', $row[4])->select('id')->firstOrFail();
                                $discipline = DB::table('disciplines')->where('name', $row[5])->select('id')->firstOrFail();
                                $finnancing_source = DB::table('finnancing_sources')->where('name', $row[31])->select('id')->firstOrFail();

                                $inidialDate = $row[7] ?? null;
                                $endDate = $row[8] ?? null;

                                $repeaterData[] = [
                                    'activity_name' => $row[0] ?? null,
                                    'category_id' => $category->id,
                                    'activity_goal' => $row[2] ?? null,
                                    'description' => $row[3] ?? null,
                                    'activity_type_id' => $activityType->id,
                                    'discipline_id' => $discipline->id,
                                    'author_name' => $row[6] ?? null,
                                    'initial_date' => $inidialDate,
                                    'end_date' => $endDate,
                                    'name_space_held' => $row[8] ?? null,
                                    'locality' => $row[9] ?? null,
                                    'municipality' => $row[10] ?? null,
                                    'total' => $row[11] ?? null,
                                    'women_total' => $row[12] ?? null,
                                    'men_total' => $row[13] ?? null,
                                    'children_girls' => $row[14] ?? null,
                                    'children_boys' => $row[15] ?? null,
                                    'youth_women' => $row[16] ?? null,
                                    'youth_men' => $row[17] ?? null,
                                    'adult_women' => $row[18] ?? null,
                                    'adult_men' => $row[19] ?? null,
                                    'senior_women' => $row[20] ?? null,
                                    'senior_men' => $row[21] ?? null,
                                    'social_women' => $row[22] ?? null,
                                    'social_childrens' => $row[23] ?? null,
                                    'social_seniors' => $row[24] ?? null,
                                    'social_indigenous' => $row[25] ?? null,
                                    'social_disabled' => $row[26] ?? null,
                                    'social_migrants' => $row[27] ?? null,
                                    'social_afrodescendants' => $row[28] ?? null,
                                    'social_incarcerated' => $row[29] ?? null,
                                    'social_lgbtttiq' => $row[30] ?? null,
                                    'finnancing_source_id' => $finnancing_source->id,
                                ];
                            }
                            $set('activities', $repeaterData);
                        }
                    }),

                Forms\Components\Repeater::make('activities')
                    ->relationship('activities')
                    ->label('Actividades')
                    ->required()
                    ->collapsible()
                    ->columnSpanFull()
                    ->itemLabel(fn(array $state): ?string => $state['activity_name'] ?? null)
                    ->addActionLabel('Agrega otra actividad')
                    ->cloneable()
                    ->schema([
                        Forms\Components\TextInput::make('activity_name')
                            ->placeholder('Escriba el nombre de la actividad')
                            ->required()
                            ->label('Nombre de la actividad'),
                        Forms\Components\Select::make('category_id')
                            ->label('Categoría')
                            ->placeholder(fn(Forms\Get $get): string => empty($get('category_id')) ? 'Primero Selecciona una categoria' : 'Selecciona una opción')
                            ->options(Category::all()->pluck('name', 'id')),
                        Forms\Components\Textarea::make('activity_goal')
                            ->placeholder('Escriba las metas de las actividades')
                            ->required()
                            ->label('Metas de la actividad'),
                        Forms\Components\Textarea::make('description')
                            ->placeholder('Escriba la descripción')
                            ->required()
                            ->label('Descripción'),
                        Forms\Components\Select::make('activity_type_id')
                            ->label('Tipo de actividad')
                            ->required()
                            ->placeholder(fn(Forms\Get $get): string => empty($get('activity_type_id')) ? 'Primero Selecciona un tipo de actividad' : 'Selecciona una opción')
                            ->options(ActivityType::query()->pluck('name', 'id')),
                        Forms\Components\Select::make('discipline_id')
                            ->label('Tipo de disciplina')
                            ->required()
                            ->placeholder(fn(Forms\Get $get): string => empty($get('discipline_id')) ? 'Primero Selecciona un tipo de disciplina' : 'Selecciona una opción')
                            ->options(Discipline::query()->pluck('name', 'id')),
                        Forms\Components\TextInput::make('author_name')
                            ->label('Nombre del autor')
                            ->required()
                            ->placeholder('Escribe el nombre del autor')
                            ->columnSpan(2),
                        Forms\Components\DatePicker::make('initial_date')
                            ->label('Fecha inicial')
                            ->required(),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('Fecha final')
                            ->required(),
                        Forms\Components\TextInput::make('name_space_held')
                            ->label('Nombre del lugar donde se realizó')
                            ->required()
                            ->placeholder('Escriba el nombre del lugar donde se realizó')
                            ->columnSpan(2),
                        Forms\Components\Select::make('municipality')
                            ->label('Municipio')
                            ->required()
                            ->reactive()
                            ->options(MunicipalityEnum::class),
                        Forms\Components\Select::make('locality')
                            ->label('Localidad')
                            ->placeholder(function (callable $get) {
                                if ($get('municipality') !== null) {
                                    return "Selecciona una localidad de " . $get('municipality');
                                } else {
                                    return "Primero seleccione un municipio";
                                }
                            })
                            ->required()
                            ->reactive()
                            ->options(function (callable $get) {
                                $municipio = $get('municipality');
                                return match ($municipio) {
                                    "LA PAZ" => ["La Paz", "Todos Santos", "El Centenario", "El Pescadero"],
                                    "LORETO" => ["Loreto", "Ensenada Blanca", "Ligüí", "Puerto Agua Verde"],
                                    "LOS CABOS" => ["San José del Cabo", "Cabo San Lucas", "Colonia del Sol", "Las Palmas"],
                                    "COMONDÚ" => ["Ciudad Constitución", "Ciudad Insurgentes", "Puerto San Carlos", "Puerto Adolfo López Mateos"],
                                    "MULEGÉ" => ["Guerrero Negro", "Santa Rosalía", "Villa Alberto Andrés Alvarado Arámburo", "Heroica Mulegé"],
                                    default => null,
                                };
                            }),
                        //Personas

                        Forms\Components\Section::make('Población atendida')
                            ->columns(1)
                            ->collapsible()
                            ->description("Total de personas atendidas")
                            ->schema([
                                Forms\Components\TextInput::make('total')
                                    ->columnSpanFull()
                                    ->placeholder('Escriba la cantidad de personas total')
                                    ->required()
                                    ->integer()
                                    ->label('Total de personas'),
                                Forms\Components\Fieldset::make('Personas')
                                    ->schema([
                                        Forms\Components\TextInput::make('women_total')
                                            ->placeholder('Escriba la cantidad de personas femeninas')
                                            ->required()
                                            ->integer()
                                            ->label('Total de mujeres')
                                            ->columnSpan(2),
                                        Forms\Components\TextInput::make('men_total')
                                            ->placeholder('Escriba la cantidad de personas masculinas')
                                            ->integer()
                                            ->required()
                                            ->label('Total de hombres')
                                            ->columnSpan(2),

                                    ]),


                                Forms\Components\Fieldset::make('Niñas y niños')
                                    ->schema([
                                        Forms\Components\TextInput::make('children_girls')
                                            ->label('Femenino')
                                            ->placeholder('Escriba la cantidad de niñas'),
                                        Forms\Components\TextInput::make('children_boys')
                                            ->label('Masculino')
                                            ->placeholder('Escriba la cantidad de niños'),
                                    ]),
                                Forms\Components\Fieldset::make('Jóvenes')
                                    ->schema([
                                        Forms\Components\TextInput::make('youth_women')
                                            ->label('Femenino')
                                            ->placeholder('Escriba la cantidad de jóvenes mujeres'),
                                        Forms\Components\TextInput::make('youth_men')
                                            ->label('Masculino')
                                            ->placeholder('Escriba la cantidad de jóvenes hombres'),
                                    ]),
                                Forms\Components\Fieldset::make('Adultos')
                                    ->schema([
                                        Forms\Components\TextInput::make('adult_women')
                                            ->label('Femenino')
                                            ->placeholder('Escriba la cantidad de adultos mujeres'),
                                        Forms\Components\TextInput::make('adult_men')
                                            ->label('Masculino')
                                            ->placeholder('Escriba la cantidad de adultos hombres'),
                                    ]),
                                Forms\Components\Fieldset::make('Personas mayores')
                                    ->schema([
                                        Forms\Components\TextInput::make('senior_women')
                                            ->label('Femenino')
                                            ->placeholder('Escriba la cantidad de personas mayores mujeres'),
                                        Forms\Components\TextInput::make('senior_men')
                                            ->label('Masculino')
                                            ->placeholder('Escriba la cantidad de personas mayores hombres'),
                                    ])

                            ]),

                        Forms\Components\Section::make('Grupo social')
                            ->collapsed()
                            ->description('De ser el caso, grupo social al que va dirigido.')
                            ->columns(3)
                            ->schema([
                                Forms\Components\TextInput::make('social_women')
                                    ->placeholder('Escriba la cantidad de mujeres')
                                    ->label('Mujeres'),
                                Forms\Components\TextInput::make('social_childrens')
                                    ->label('Niños, niñas y jóvenes')
                                    ->placeholder('Escriba la cantidad total de niños, niñas y jóvenes'),
                                Forms\Components\TextInput::make('social_seniors')
                                    ->placeholder('Escriba la cantidad de adultos mayores')
                                    ->label('Adultos mayores'),
                                Forms\Components\TextInput::make('social_indigenous')
                                    ->label('Indígenas')
                                    ->placeholder('Escriba la cantidad de personas indígenas'),
                                Forms\Components\TextInput::make('social_disabled')
                                    ->placeholder('Escriba la cantidad de personas discapacitadas')
                                    ->label('Discapacitados'),
                                Forms\Components\TextInput::make('social_migrants')
                                    ->placeholder('Escriba la cantidad de migrantes')
                                    ->label('Migrantes'),
                                Forms\Components\TextInput::make('social_afrodescendants')
                                    ->placeholder('Escriba la cantidad de afrodescendientes')
                                    ->label('Afrodescendientes'),
                                Forms\Components\TextInput::make('social_incarcerated')
                                    ->label('En reclusión')
                                    ->placeholder('Escriba la cantidad de personas en reclusión'),
                                Forms\Components\TextInput::make('social_lgbtttiq')
                                    ->placeholder('Escriba la cantidad de personas LGBTQ+')
                                    ->label('LGBTQ+'),

                            ]),
                        Forms\Components\Select::make('finnancing_source_id')
                            ->label('Fuente de financiamiento')
                            ->columnSpanFull()
                            ->placeholder(fn(Forms\Get $get): string => empty($get('finnancing_source_id')) ? 'Primero Selecciona un tipo de financiamiento' : 'Selecciona una opción')
                            ->options(FinnancingSource::query()->pluck('name', 'id')),

                        Forms\Components\Hidden::make('area_id')
                            ->default((int)Auth::user()->area_id),
                    ])->columns(2)->deleteAction(fn(Action $action) => $action->requiresConfirmation()),
            ]);
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.description')
                    ->searchable()
                    ->limit(10)
                    ->label('Proyecto'),
                TextColumn::make('area.name')
                    ->label('Área'),
                TextColumn::make('user.name')
                    ->label('Usuario'),
                Tables\Columns\SelectColumn::make('status_id')
                    ->options(Status::query()->pluck('name', 'id'))
                    ->rules(['required'])
                    ->selectablePlaceholder(false)
                    ->label('Estado')
                    ->afterStateUpdated(function (string $state, Report $record) {
                        $record->update([
                            'status_id' => $state,
                        ]);
                        $record->save();
                    }),
            ])
            ->filters([
                SelectFilter::make('quarter')
                    ->label('Filter By Quarter')
                    ->options([
                        1 => 'T1 (Enero - Marzo)',
                        2 => 'T2 (Abril - Junio)',
                        3 => 'T3 (Julio - Septiembre)',
                        4 => 'T4 (Octubre - Diciembre)',
                    ])
                    ->query(function (Builder $query, $data) {
                        if ($data['value']) {
                            $query->whereHas('project', function ($projectQuery) use ($data) {
                                $projectQuery->byQuarter($data['value']);
                            });
                        }
                    }),
                SelectFilter::make('Área')
                    ->relationship('area', 'name'),
                SelectFilter::make('Proyecto')
                    ->relationship('project', 'description'),
                SelectFilter::make('Usuario')
                    ->relationship('user', 'name'),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('Exportar')
                        ->label('Exportar')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(fn() => \Maatwebsite\Excel\Facades\Excel::download(new ReportsExport(), 'reports.xlsx')),
                    Tables\Actions\Action::make('Notificar')
                        ->icon('heroicon-o-exclamation-triangle')
                        ->form(function ($record) {
                            return [
                                Forms\Components\TextInput::make('title')
                                    ->label('Título')
                                    ->placeholder('Escribe el título de la notificacion')
                                    ->default($record->project->description)
                                    ->required(),
                                Forms\Components\TextArea::make('description')
                                    ->label('Descripción')
                                    ->placeholder('Escribe la descripción de la notificacion')
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
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
            'view' => Pages\ViewReport::route('/{record}'),
        ];
    }
}
