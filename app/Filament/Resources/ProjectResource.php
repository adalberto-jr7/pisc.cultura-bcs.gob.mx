<?php

namespace App\Filament\Resources;

use App\Enums\MonthsEnum;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Area;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $label = 'Proyectos';

    protected static ?string $navigationGroup = 'Reportes';

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextArea::make('description')
                ->required()
                    ->placeholder('Escriba la descripción de el proyecto')
                    ->label('Descripción'),
                Forms\Components\TextInput::make('code')
                ->required()
                    ->placeholder('Escriba el código del proyecto')
                    ->label('Código'),
                Forms\Components\Select::make('initial_month')
                ->required()
                    ->placeholder('Seleccione una opción')
                    ->label('Mes inicial')
                    ->options([
                        'enero' => 'Enero',
                        'febrero' => 'Febrero',
                        'marzo' => 'Marzo',
                        'abril' => 'Abril',
                        'mayo' => 'Mayo',
                        'junio' => 'Junio',
                        'julio' => 'Julio',
                        'agosto' => 'Agosto',
                        'septiembre' => 'Septiembre',
                        'octubre' => 'Octubre',
                        'noviembre' => 'Noviembre',
                        'diciembre' => 'Diciembre',
                    ]),
                Forms\Components\Select::make('last_month')
                ->required()
                    ->placeholder('Seleccione una opción')
                    ->label('Mes final')
                    ->options([
                        'enero' => 'Enero',
                        'febrero' => 'Febrero',
                        'marzo' => 'Marzo',
                        'abril' => 'Abril',
                        'mayo' => 'Mayo',
                        'junio' => 'Junio',
                        'julio' => 'Julio',
                        'agosto' => 'Agosto',
                        'septiembre' => 'Septiembre',
                        'octubre' => 'Octubre',
                        'noviembre' => 'Noviembre',
                        'diciembre' => 'Diciembre',
                    ]),
                Forms\Components\TextInput::make('year')
                ->required()
                    ->placeholder('Escriba el año del proyecto')
                    ->label('Año'),
                Forms\Components\Select::make('area_id')
                ->required()
                    ->placeholder('Seleccione un área')
                    ->label('Área')
                    ->options(Area::query()->pluck('name', 'id'))
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción'),
                Tables\Columns\TextColumn::make('area.name')
                    ->label('Área'),
                Tables\Columns\TextColumn::make('initial_month')
                    ->label('Período')
                    ->formatStateUsing(function (Project $project) {
                        return $project->initial_month . ' - ' . $project->last_month . ' del ' . $project->year;
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                Tables\Actions\EditAction::make()->modal()
                ->slideOver(),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
