<?php

namespace App\Filament\Pages\Auth;

use  Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->required(),
                TextInput::make('password')
                    ->required()
            ]);
    }
}
