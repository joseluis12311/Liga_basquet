<?php

namespace App\Enums;

use App\Enums\Concerns\TieneOpciones;

enum EstadoPartido: string
{
    use TieneOpciones;

    case Programado = 'programado';
    case EnVivo = 'en_vivo';
    case Finalizado = 'finalizado';

    public function etiqueta(): string
    {
        return match ($this) {
            self::Programado => 'Programado',
            self::EnVivo => 'En vivo',
            self::Finalizado => 'Final',
        };
    }
}