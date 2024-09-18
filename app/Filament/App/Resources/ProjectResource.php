<?php

namespace App\Filament\App\Resources;

use App\Enums\MonthsEnum;
use App\Filament\App\Resources\ProjectResource\Pages;
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
                    ->label('Descripción')
                    ->columnSpan(2),
                Forms\Components\TextInput::make('code')
                    ->label('Código'),
                Forms\Components\Select::make('area_id')
                    ->required()
                    ->label('Área')
                    ->placeholder(fn(Forms\Get $get): string => empty($get('area_id')) ? 'Primero Selecciona un área' : 'Selecciona una opción')
                    ->options(Area::query()->pluck('name', 'id')),
                Forms\Components\Select::make('initial_month')
                    ->label('Mes inicial')
                    ->options(MonthsEnum::toArray()),
                Forms\Components\Select::make('last_month')
                    ->label('Mes final')
                    ->options(MonthsEnum::toArray()),
                Forms\Components\TextInput::make('year')
                    ->label('Año')
                    ->length(4)
                    ->numeric(),

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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
