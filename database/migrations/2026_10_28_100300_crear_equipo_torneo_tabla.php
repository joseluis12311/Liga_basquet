<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipo_torneo', function (Blueprint $tabla) {
            $tabla->id();
            $tabla->foreignId('torneo_id')->constrained('torneos')->cascadeOnDelete();
            $tabla->foreignId('equipo_id')->constrained('equipos')->cascadeOnDelete();
            $tabla->string('grupo', 40)->nullable();                 
            $tabla->smallInteger('ajuste_puntos')->default(0);       
            $tabla->timestamps();

            
            $tabla->unique(['torneo_id', 'equipo_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipo_torneo');
    }
};
