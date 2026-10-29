<?php

namespace App\Enums\Concerns;
trait TieneOpciones
{
    public static function opciones(): array
    {
        $opciones = [];
        foreach (self::cases() as $caso) {
            $opciones[$caso->value] = $caso->etiqueta();
        }
        return $opciones;
    }
}