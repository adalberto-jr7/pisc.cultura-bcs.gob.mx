<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum MunicipalityEnum: string implements HasLabel
{
    case LA_PAZ = 'LA PAZ';
    case COMONDU = 'COMONDÚ';
    case LOS_CABOS = 'LOS CABOS';
    case MULEGE = 'MULEGÉ';
    case LORETO = 'LORETO';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::LA_PAZ => "LA PAZ",
            self::COMONDU => "COMONDÚ",
            self::LOS_CABOS => "LOS CABOS",
            self::MULEGE => "MULEGÉ",
            self::LORETO => "LORETO",
        };
    }

    public static function toArray(): array
    {
        return array_column(MunicipalityEnum::cases(), 'value');
    }
}
