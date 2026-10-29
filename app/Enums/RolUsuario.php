<?php

namespace App\Enums;

use App\Enums\Concerns\TieneOpciones;

enum RolUsuario: string
{
    use TieneOpciones;

    case Administrador = 'administrador';
    case Usuario = 'usuario';

    public function etiqueta(): string
    {
        return match ($this) {
            self::Administrador => 'Administrador',
            self::Usuario => 'Usuario',
        };
    }
}