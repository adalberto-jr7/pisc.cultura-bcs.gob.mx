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
                    ->columnSpan(2)
                    ->placeholder('Escriba la descripción de el proyecto')
                    ->label('Descripción'),
                Forms\Components\Select::make('initial_month')
                    ->placeholder('Seleccione una opción')
                    ->label('Mes inicial')
                    ->searchable()
                    ->options(MonthsEnum::class),
                Forms\Components\Select::make('last_month')
                    ->placeholder('Seleccione una opción')
                    ->label('Mes final')
                    ->searchable()
                    ->options(MonthsEnum::class),
                Forms\Components\Select::make('area_id')
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
                        return $project->initial_month->getLabel() . ' - ' . $project->last_month->getLabel() . ' del ' . $project->year;
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
            //'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
