<?php

namespace App\Enums;

enum MonthsEnum: string
{

    case ENERO = 'enero';
    case FEBRERO = 'febrero';
    case MARZO = 'marzo';
    case ABRIL = 'abril';
    case MAYO = 'mayo';
    case JUNIO = 'junio';
    case JULIO = 'julio';
    case AGOSTO = 'agosto';
    case SEPTIEMBRE = 'septiembre';
    case OCTUBRE = 'octubre';
    case NOVIEMBRE = 'noviembre';
    case DICIEMBRE = 'diciembre';

    public static function toArray(): array
    {
        return array_column(MonthsEnum::cases(), 'value');
    }
}
