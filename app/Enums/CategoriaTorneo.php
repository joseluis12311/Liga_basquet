<?php
namespace App\Enums;

use App\Enums\Concerns\TieneOpciones;

enum CategoriaTorneo: string
{
    use TieneOpciones;

    case Hombres = 'hombres';
    case Mujeres = 'mujeres';
    case Ninos = 'ninos';
    case Ninas = 'ninas';

    public function etiqueta(): string
    {
        return match ($this) {
            self::Hombres => 'Hombres',
            self::Mujeres => 'Mujeres',
            self::Ninos => 'Niños',
            self::Ninas => 'Niñas',
        };
    }
}
EOF


