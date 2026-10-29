<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jugadores', function (Blueprint $tabla) {
            $tabla->id();
            
            $tabla->foreignId('equipo_id')->constrained('equipos')->cascadeOnDelete();
            $tabla->string('nombres', 80);
            $tabla->string('apellidos', 80);
            $tabla->unsignedTinyInteger('dorsal');
            $tabla->string('posicion', 20);                          
            $tabla->unsignedSmallInteger('estatura_cm')->nullable();
            $tabla->date('fecha_nacimiento')->nullable();
            $tabla->timestamps();

            
            $tabla->unique(['equipo_id', 'dorsal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jugadores');
    }
};
