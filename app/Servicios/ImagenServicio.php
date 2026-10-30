<?php

namespace App\Servicios;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImagenServicio
{
    public function guardar(UploadedFile $archivo, string $carpeta): string
    {
        $nombre = Str::random(24) . '.' . $archivo->extension();
        $archivo->move(public_path("assets/img/{$carpeta}"), $nombre);
        return $nombre;
    }

    public function eliminar(?string $nombre, string $carpeta): void
    {
        if ($nombre) {
            File::delete(public_path("assets/img/{$carpeta}/{$nombre}"));
        }
    }
}