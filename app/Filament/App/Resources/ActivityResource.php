<?php

namespace App\Filament\App\Resources;

use App\Enums\StatesEnum;
use App\Filament\App\Resources\ActivityResource\Pages;
use App\Models\Activity;
use App\Models\ActivityType;
use App\Models\Category;
use App\Models\Discipline;
use App\Models\FinnancingSource;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Reportes';

    protected static ?string $label = 'Actividades';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('activity_name')
                    ->placeholder('Escriba el nombre de la actividad')
                    ->required()
                    ->label('Nombre de la actividad'),
                Forms\Components\Select::make('category_id')
<<<<<<< HEAD
                    ->label('Cateogoria')
                    ->required()
                    ->placeholder(fn(Forms\Get $get): string => empty($get('category_id')) ? 'Primero Selecciona un categoria' : 'Selecciona una opción')
=======
                    ->label('Categoria')
                    ->placeholder(fn(Forms\Get $get): string => empty($get('category_id')) ? 'Primero Selecciona una categoria' : 'Selecciona una opción')
>>>>>>> 0c49eb72bb200a1077478fd7dca19041495d34d0
                    ->options(Category::query()->pluck('name', 'id')),
                Forms\Components\Textarea::make('activity_goal')
                    ->placeholder('Escriba las metas de las actividad')
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
                Forms\Components\Select::make('locality')
                    ->label('Localidad')
                    ->required()
                    ->options(StatesEnum::class),
                Forms\Components\Select::make('municipality')
                    ->label('Municipio')
                    ->required()
                    ->options(StatesEnum::class),
                //Personas

<<<<<<< HEAD
                Section::make('Poblacion atendida')
                    ->collapsible()
                    ->columns(2)
=======
                Section::make('Población atendida')
                    ->columns(1)
>>>>>>> 0c49eb72bb200a1077478fd7dca19041495d34d0
                    ->schema([
                        Forms\Components\TextInput::make('total')
                            ->columnSpanFull()
                            ->placeholder('Escriba la cantidad de personas total')
                            ->required()
                            ->integer()
                            ->label('Total de personas'),
                        Fieldset::make('Personas')
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


                        Fieldset::make('Niñas y niños')
                            ->schema([
                                Forms\Components\TextInput::make('children_girls')
                                    ->label('Femenino'),
                                Forms\Components\TextInput::make('children_boys')
                                    ->label('Masculino'),
                            ]),
                        Fieldset::make('Jóvenes')
                            ->schema([
                                Forms\Components\TextInput::make('youth_women')
                                    ->label('Femenino'),
                                Forms\Components\TextInput::make('youth_men')
                                    ->label('Masculino'),
                            ]),
                        Fieldset::make('Adultos')
                            ->schema([
                                Forms\Components\TextInput::make('adult_women')
                                    ->label('Femenino'),
                                Forms\Components\TextInput::make('adult_men')
                                    ->label('Masculino'),
                            ]),
                        Fieldset::make('Personas mayores')
                            ->schema([
                                Forms\Components\TextInput::make('senior_women')
                                    ->label('Femenino'),
                                Forms\Components\TextInput::make('senior_men')
                                    ->label('Masculino'),
                            ])

                    ]),

                Section::make('Grupo social')
                    ->collapsed()
                    ->description('De ser el caso, grupo social al que va dirigido.')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('social_women')
                            ->placeholder('Escriba la cantidad de mujeres')
                            ->label('Mujeres'),
                        Forms\Components\TextInput::make('social_childrens')
<<<<<<< HEAD
                            ->placeholder('Escriba la cantidad de ninas, ninos y jovenes')
                            ->label('Ninos, ninas y jovenes'),
=======
                            ->label('Niños, niñas y jóvenes'),
>>>>>>> 0c49eb72bb200a1077478fd7dca19041495d34d0
                        Forms\Components\TextInput::make('social_seniors')
                            ->placeholder('Escriba la cantidad de adultos mayores')
                            ->label('Adultos mayores'),
                        Forms\Components\TextInput::make('social_indigenous')
<<<<<<< HEAD
                            ->placeholder('Escriba la cantidad de indigenas')
                            ->label('Indigenas'),
=======
                            ->label('Indígenas'),
>>>>>>> 0c49eb72bb200a1077478fd7dca19041495d34d0
                        Forms\Components\TextInput::make('social_disabled')
                            ->placeholder('Escriba la cantidad de discapacitados')
                            ->label('Discapacitados'),
                        Forms\Components\TextInput::make('social_migrants')
                            ->placeholder('Escriba la cantidad de migrantes')
                            ->label('Migrantes'),
                        Forms\Components\TextInput::make('social_afrodescendants')
                            ->placeholder('Escriba la cantidad de afrodescendientes')
                            ->label('Afrodescendientes'),
                        Forms\Components\TextInput::make('social_incarcerated')
<<<<<<< HEAD
                            ->placeholder('Escriba la cantidad de personas en reclusion')
                            ->label('En reclusion'),
=======
                            ->label('En reclusión'),
>>>>>>> 0c49eb72bb200a1077478fd7dca19041495d34d0
                        Forms\Components\TextInput::make('social_lgbtttiq')
                            ->placeholder('Escriba la cantidad de personas lgbt+')
                            ->label('LGBTQ+'),

                    ]),
                Forms\Components\Select::make('finnancing_source_id')
                    ->label('Fuente de financiamiento')
                    ->columnSpanFull()
                    ->placeholder(fn(Forms\Get $get): string => empty($get('finnancing_source_id')) ? 'Primero Selecciona un tipo de financiamiento' : 'Selecciona una opción')
                    ->options(FinnancingSource::query()->pluck('name', 'id')),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('activity_name')
                    ->limit(25)
                    ->label('Nombre de la actividad'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoria'),
                Tables\Columns\TextColumn::make('activityType.name')
                    ->label('Tipo de actividad'),
                Tables\Columns\TextColumn::make('discipline.name')
                    ->label('Disciplina'),
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
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }
}
