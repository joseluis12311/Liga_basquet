<?php

namespace App\Enums;

use App\Enums\Concerns\TieneOpciones;

enum PosicionJugador: string
{
    use TieneOpciones;

    case Base = 'base';
    case Escolta = 'escolta';
    case Alero = 'alero';
    case AlaPivot = 'ala_pivot';
    case Pivot = 'pivot';

    public function etiqueta(): string
    {
        return match ($this) {
            self::Base => 'Base',
            self::Escolta => 'Escolta',
            self::Alero => 'Alero',
            self::AlaPivot => 'Ala-pívot',
            self::Pivot => 'Pívot',
        };
    }
}