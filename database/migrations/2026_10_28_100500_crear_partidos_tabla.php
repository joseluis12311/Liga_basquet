<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partidos', function (Blueprint $tabla) {
            $tabla->id();
            $tabla->foreignId('torneo_id')->constrained('torneos')->cascadeOnDelete();

           
            $tabla->foreignId('equipo_local_id')->constrained('equipos')->restrictOnDelete();
            $tabla->foreignId('equipo_visitante_id')->constrained('equipos')->restrictOnDelete();

            $tabla->dateTime('fecha_hora');
            $tabla->string('fase', 80)->nullable();                  
            $tabla->string('sede', 120)->nullable();
            $tabla->string('estado', 12)->default('programado');     
            $tabla->unsignedSmallInteger('puntos_local')->nullable();
            $tabla->unsignedSmallInteger('puntos_visitante')->nullable();
            $tabla->timestamps();

            
            $tabla->index('fecha_hora');
            $tabla->index(['estado', 'fecha_hora']);
            $tabla->index(['torneo_id', 'fecha_hora']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partidos');
    }
};
