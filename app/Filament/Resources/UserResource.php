<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Area;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $label = "Usuario";

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre Completo')
                    ->placeholder('Ingresa el nombre completo'),
                Forms\Components\TextInput::make('username')
                    ->label('Usuario')
                    ->placeholder('Ingresa el nombre de usuario'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->label('Correo Electronico')
                    ->placeholder('Ingresa el correo electronico'),
                Forms\Components\TextInput::make('number_phone')
                    ->label('Numero de telefono')
                    ->tel()
                    ->placeholder('Ingresa el numero de telefono'),
                Forms\Components\TextInput::make('position')
                    ->label('Posicion')
                    ->placeholder('Ingrese la posicion')
                    ->columnSpan(2),
                Forms\Components\Select::make('area_id')
                    ->label('Area')
                    ->placeholder('Seleccione un area')
                    ->options(function (Forms\Get $get) {
                        return Area::where('id', $get('area_id'))->pluck('name', 'id');
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('username'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('number_phone'),
                Tables\Columns\TextColumn::make('position'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
