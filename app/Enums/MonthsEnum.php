<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum MonthsEnum: string implements HasLabel
{

    case ENERO = 'Enero';
    case FEBRERO = 'Febrero';
    case MARZO = 'Marzo';
    case ABRIL = 'Abril';
    case MAYO = 'Mayo';
    case JUNIO = 'Junio';
    case JULIO = 'Julio';
    case AGOSTO = 'Agosto';
    case SEPTIEMBRE = 'Septiembre';
    case OCTUBRE = 'Octubre';
    case NOVIEMBRE = 'Noviembre';
    case DICIEMBRE = 'Diciembre';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ENERO => 'Enero',
            self::FEBRERO => 'Febrero',
            self::MARZO => 'Marzo',
            self::ABRIL => 'Abril',
            self::MAYO => 'Mayo',
            self::JUNIO => 'Junio',
            self::JULIO => 'Julio',
            self::AGOSTO => 'Agosto',
            self::SEPTIEMBRE => 'Septiembre',
            self::OCTUBRE => 'Octubre',
            self::NOVIEMBRE => 'Noviembre',
            self::DICIEMBRE => 'Diciembre',
        };
    }

    public static function toArray(): array
    {
        return array_column(MonthsEnum::cases(), 'value');
    }
}
