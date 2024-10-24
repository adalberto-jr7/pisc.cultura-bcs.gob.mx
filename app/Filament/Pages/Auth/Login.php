<?php

namespace App\Filament\Pages\Auth;

use  Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    public function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('email')
            ->label('Correo Electrónico')
                ->placeholder('Ingrese el correo electrónico')
                ->required(),
                TextInput::make('password')
                ->label('Contraseña')
                ->placeholder('Ingrese su contraseña')
                ->password()
                ->revealable()
                ->required(),
                Checkbox::make('Recuérdame')
            ]);
    }
}
