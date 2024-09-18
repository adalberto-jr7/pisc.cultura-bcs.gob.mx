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
                    ->label('Nombre de la actividad'),
                Forms\Components\Select::make('category_id')
                    ->label('Categoria')
                    ->placeholder(fn(Forms\Get $get): string => empty($get('category_id')) ? 'Primero Selecciona una categoria' : 'Selecciona una opción')
                    ->options(Category::query()->pluck('name', 'id')),
                Forms\Components\Textarea::make('activity_goal')
                    ->label('Metas de la actividad'),
                Forms\Components\Textarea::make('description')
                    ->label('Descripción'),
                Forms\Components\Select::make('activity_type_id')
                    ->label('Tipo de actividad')
                    ->placeholder(fn(Forms\Get $get): string => empty($get('activity_type_id')) ? 'Primero Selecciona un tipo de actividad' : 'Selecciona una opción')
                    ->options(ActivityType::query()->pluck('name', 'id')),
                Forms\Components\Select::make('discipline_id')
                    ->label('Tipo de disciplina')
                    ->placeholder(fn(Forms\Get $get): string => empty($get('discipline_id')) ? 'Primero Selecciona un tipo de disciplina' : 'Selecciona una opción')
                    ->options(Discipline::query()->pluck('name', 'id')),
                Forms\Components\TextInput::make('author_name')
                    ->label('Nombre del autor')
                    ->columnSpan(2),
                Forms\Components\DatePicker::make('initial_date')
                    ->label('Fecha inicial')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->label('Fecha final')
                    ->required(),
                Forms\Components\TextInput::make('name_space_held')
                    ->label('Nombre del lugar donde se realizó')
                    ->columnSpan(2),
                Forms\Components\Select::make('locality')
                    ->label('Localidad')
                    ->options(StatesEnum::toArray()),
                Forms\Components\Select::make('municipality')
                    ->label('Municipio')
                    ->options(StatesEnum::toArray()),
                Forms\Components\Select::make('finnancing_source_id')
                    ->label('Fuente de financiamiento')
                    ->columnSpanFull()
                    ->placeholder(fn(Forms\Get $get): string => empty($get('finnancing_source_id')) ? 'Primero Selecciona un tipo de financiamiento' : 'Selecciona una opción')
                    ->options(FinnancingSource::query()->pluck('name', 'id')),
                //Personas

                Section::make('Población atendida')
                    ->columns(1)
                    ->schema([
                        Forms\Components\TextInput::make('total')
                            ->label('Total de personas'),

                        Fieldset::make('Personas')
                            ->schema([
                                Forms\Components\TextInput::make('total_women')
                                    ->label('Total de mujeres')
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('men_total')
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
                    ->description('De ser el caso, grupo social al que va dirigido.')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('social_women')
                            ->label('Mujeres'),
                        Forms\Components\TextInput::make('social_childrens')
                            ->label('Niños, niñas y jóvenes'),
                        Forms\Components\TextInput::make('social_seniors')
                            ->label('Adultos mayores'),
                        Forms\Components\TextInput::make('social_indigenous')
                            ->label('Indígenas'),
                        Forms\Components\TextInput::make('social_disabled')
                            ->label('Discapacitados'),
                        Forms\Components\TextInput::make('social_migrants')
                            ->label('Migrantes'),
                        Forms\Components\TextInput::make('social_afrodescendants')
                            ->label('Afrodescendientes'),
                        Forms\Components\TextInput::make('social_incarcerated')
                            ->label('En reclusión'),
                        Forms\Components\TextInput::make('social_lgbtttiq')
                            ->label('LGBTQ+'),

                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
