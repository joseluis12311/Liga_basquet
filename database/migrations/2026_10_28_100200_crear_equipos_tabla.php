<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $tabla) {
            $tabla->id();
            $tabla->string('nombre', 100)->unique();
            $tabla->string('slug', 120)->unique();
            $tabla->string('sigla', 3)->unique();             
            $tabla->string('ciudad', 100);
            $tabla->string('entrenador', 100)->nullable();
            $tabla->unsignedSmallInteger('anio_fundacion')->nullable();
            $tabla->string('escudo')->nullable();             
            $tabla->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
