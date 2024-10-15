<?php

namespace App\Filament\App\Resources;

use App\Enums\MunicipalityEnum;
use App\Filament\App\Resources\ReportResource\Pages;
use App\Filament\App\Resources\ReportResource\RelationManagers;
use App\Imports\ActivitiesImport;
use App\Models\ActivityType;
use App\Models\Category;
use App\Models\Discipline;
use App\Models\FinnancingSource;
use App\Models\Project;
use App\Models\Report;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Reportes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->label('Proyecto')
                    ->columnSpanFull()
                    ->required()
                    ->placeholder(fn(Forms\Get $get): string => empty($get('area_id')) ? 'Primero selecciona un proyecto' : 'Selecciona una opcion')
                    ->options(Project::where('area_id', Auth::user()->area_id)->pluck('description', 'id')),
                Forms\Components\Hidden::make('area_id')
                    ->default(Auth::user()->area_id),
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::user()->id),
                Forms\Components\FileUpload::make('excel_file')
                    ->label('Archivo excel')
                    ->placeholder('Selecciona un archivo')
                    ->uploadingMessage('Subiendo Actividades...')
                    ->required()
                    ->reactive()
                    ->columnSpanFull()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $rows = \Maatwebsite\Excel\Facades\Excel::toArray(new ActivitiesImport, $state);
                            $repeaterData = [];

                            foreach ($rows[0] as $row) {
                                $category = Category::where('name', $row[1])->firstOrFail();
                                $activityType = ActivityType::where('name', $row[4])->firstOrFail();
                                $discipline = Discipline::where('name', $row[5])->firstOrFail();
                                $finnaning_source = FinnancingSource::where('name', $row[31])->firstOrFail();

                                $repeaterData[] = [
                                    'activity_name' => $row[0] ?? null,
                                    'category_id' => $category->id,
                                    'activity_goal' => $row[2] ?? null,
                                    'description' => $row[3] ?? null,
                                    'activity_type_id' => $activityType->id,
                                    'discipline_id' => $discipline->id,
                                    'author_name' => $row[6] ?? null,
                                    'initial_date' => null,
                                    'end_date' => null,
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
                                    'finnancing_source_id' => $finnaning_source->idj
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
                    ->addActionLabel('Agrega otra actividad')
                    ->cloneable()
                    ->schema([
                        Forms\Components\TextInput::make('activity_name')
                            ->placeholder('Escriba el nombre de la actividad')
                            ->required()
                            ->label('Nombre de la actividad'),
                        Forms\Components\Select::make('category_id')
                            ->label('Categoría')
                            ->placeholder(fn(Forms\Get $get): string => empty($get('category_id')) ? 'Primero Selecciona una categoría' : 'Selecciona una opción')
                            ->required()
                            ->options(Category::query()->pluck('name', 'id')),
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
                            ->validationMessages([
                                'required' => 'La fecha inicial es requerida',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('Fecha final')
                            ->validationMessages([
                                'required' => 'La fecha final es requerida',
                            ])
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
                                } else return "Primero seleccione un municipio";
                            })
                            ->required()
                            ->reactive()
                            ->options(function (callable $get) {
                                $municipio = $get('municipality');
                                $localidades = match ($municipio) {
                                    "LA PAZ" => ["La Paz", "Todos Santos", "El Centenario", "El Pescadero"],
                                    "LORETO" => ["Loreto", "Ensenada Blanca", "Ligüí", "Puerto Agua Verde"],
                                    "LOS CABOS" => ["San José del Cabo", "Cabo San Lucas", "Colonia del Sol", "Las Palmas"],
                                    "COMONDÚ" => ["Ciudad Constitución", "Ciudad Insurgentes", "Puerto San Carlos", "Puerto Adolfo López Mateos"],
                                    "MULEGÉ" => ["Guerrero Negro", "Santa Rosalía", "Villa Alberto Andrés Alvarado Arámburo", "Heroica Mulegé"],
                                    default => null,
                                };
                                return $localidades;
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
                                            ->nullable()
                                            ->placeholder('Escriba la cantidad de niñas'),
                                        Forms\Components\TextInput::make('children_boys')
                                            ->label('Masculino')
                                            ->nullable()
                                            ->placeholder('Escriba la cantidad de niños'),
                                    ]),
                                Forms\Components\Fieldset::make('Jóvenes')
                                    ->schema([
                                        Forms\Components\TextInput::make('youth_women')
                                            ->label('Femenino')
                                            ->nullable()
                                            ->placeholder('Escriba la cantidad de jóvenes mujeres'),
                                        Forms\Components\TextInput::make('youth_men')
                                            ->label('Masculino')
                                            ->nullable()
                                            ->placeholder('Escriba la cantidad de jóvenes hombres'),
                                    ]),
                                Forms\Components\Fieldset::make('Adultos')
                                    ->schema([
                                        Forms\Components\TextInput::make('adult_women')
                                            ->label('Femenino')
                                            ->nullable()
                                            ->placeholder('Escriba la cantidad de adultos mujeres'),
                                        Forms\Components\TextInput::make('adult_men')
                                            ->label('Masculino')
                                            ->nullable()
                                            ->placeholder('Escriba la cantidad de adultos hombres'),
                                    ]),
                                Forms\Components\Fieldset::make('Personas mayores')
                                    ->schema([
                                        Forms\Components\TextInput::make('senior_women')
                                            ->label('Femenino')
                                            ->nullable()
                                            ->placeholder('Escriba la cantidad de personas mayores mujeres'),
                                        Forms\Components\TextInput::make('senior_men')
                                            ->label('Masculino')
                                            ->nullable()
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
                    ])
                    ->columns(2)
                    ->deleteAction(fn(Action $action) => $action->requiresConfirmation())
                    ->itemLabel(fn(array $state): ?string => $state['activity_name'] ?? null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->where('area_id', Auth::user()->area_id);
            })
            ->columns([
                Tables\Columns\TextColumn::make('project.description')
                    ->label('Proyecto'),
                Tables\Columns\TextColumn::make('area.name')
                    ->label('Área'),
                Tables\Columns\TextColumn::make('status.name')
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
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
        ];
    }
}
