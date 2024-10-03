<?php

namespace App\Filament\Resources;

use App\Exports\ReportsExport;
use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use Filament\Forms\Form;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Maatwebsite\Excel\Excel;

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

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(fn(Report $record): string => Pages\EditReport::getUrl([$record->id]))
            ->recordUrl(fn(Report $record): string => Pages\ViewReport::getUrl([$record->id]))
            ->columns([
                TextColumn::make('project.description')
                    ->searchable()
                    ->label('Proyecto'),
                TextColumn::make('area.name')
                    ->label('Área'),
                TextColumn::make('user.name')
                    ->label('Usuario'),
                TextColumn::make('status.name')
                    ->label('Estado')
            ])
            ->filters([
                SelectFilter::make('Área')
                    ->relationship('area', 'name'),
                SelectFilter::make('Proyecto')
                    ->relationship('project', 'description'),
                SelectFilter::make('Usuario')
                    ->relationship('user', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('Exportar')
                    ->label('Exportar')
                    ->action(fn() => \Maatwebsite\Excel\Facades\Excel::download(new ReportsExport(), 'reports.xlsx')),
                Tables\Actions\EditAction::make()
                    ->disabled()
                    ->hidden(),
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

    public static function canCreate(): bool
    {
        return false;
    }
}
