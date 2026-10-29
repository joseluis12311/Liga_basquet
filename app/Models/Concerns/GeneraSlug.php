<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
trait GeneraSlug
{
    public static function bootGeneraSlug(): void
    {
        static::saving(function (Model $modelo) {
            if ($modelo->slug) {
                return;
            }
            $base = Str::slug($modelo->textoParaSlug()) ?: 'elemento';
            $slug = $base;
            $contador = 2;
            while (static::query()
                ->where('slug', $slug)
                ->when($modelo->exists, fn ($consulta) => $consulta->whereKeyNot($modelo->getKey()))
                ->exists()) {
                $slug = "{$base}-{$contador}";
                $contador++;
            }
            $modelo->slug = $slug;
        });
    }
    public function textoParaSlug(): string
    {
        return (string) $this->nombre;
    }
}