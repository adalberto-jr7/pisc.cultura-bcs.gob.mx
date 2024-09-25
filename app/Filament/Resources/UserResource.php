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
                    ->required()
                    ->label('Nombre Completo')
                    ->placeholder('Ingresa el nombre completo'),
                Forms\Components\TextInput::make('username')
                    ->required()
                    ->label('Usuario')
                    ->placeholder('Ingresa el nombre de usuario'),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->label('Correo Electrónico')
                    ->placeholder('Ingresa el correo electrónico'),
                Forms\Components\TextInput::make('password')
                    ->required()
                    ->password()
                    ->revealable()
                    ->label('Contraseña')
                    ->placeholder('Ingrese la contraseña'),
                Forms\Components\TextInput::make('number_phone')
                    ->required()
                    ->label('Número de teléfono')
                    ->tel()
                    ->placeholder('Ingresa el número de teléfono'),
                Forms\Components\TextInput::make('position')
                    ->required()
                    ->label('Posición')
                    ->placeholder('Ingrese la posición'),
                Forms\Components\Select::make('area_id')
                    ->required()
                    ->label('Área')
                    ->placeholder(fn(Forms\Get $get): string => empty($get('area_id')) ? 'Primero Selecciona un área' : 'Selecciona una opción')
                    ->options(Area::query()->pluck('name', 'id'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre'),
                Tables\Columns\TextColumn::make('username')
                    ->label('Usuario'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo electrónico'),
                Tables\Columns\TextColumn::make('number_phone')
                    ->label('Número de teléfono'),
                Tables\Columns\TextColumn::make('position')
                    ->label('Posición'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
