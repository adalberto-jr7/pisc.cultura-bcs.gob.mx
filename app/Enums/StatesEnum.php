<?php

namespace App\Enums;

enum StatesEnum: string
{
    case LA_PAZ = 'LA PAZ';
    case COMONDU = 'COMONDÚ';
    case LOS_CABOS = 'LOS CABOS';
    case MULEGE = 'MULEGÉ';
    case LORETO = 'LORETO';

    public static function toArray(): array
    {
        return array_column(StatesEnum::cases(), 'value');
    }
}
