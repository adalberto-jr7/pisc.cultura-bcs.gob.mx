<?php

namespace App\Enums;

enum MonthsEnum: string
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

    public static function toArray(): array
    {
        return array_column(MonthsEnum::cases(), 'value');
    }
}
