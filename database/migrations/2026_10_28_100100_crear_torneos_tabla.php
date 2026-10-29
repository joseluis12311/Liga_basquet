<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('torneos', function (Blueprint $tabla) {
            $tabla->id();
            $tabla->string('nombre', 120);
            $tabla->string('slug', 140)->unique();            
            $tabla->string('categoria', 20)->index();         
            $tabla->string('temporada', 20);                  
            $tabla->date('fecha_inicio')->nullable();
            $tabla->date('fecha_fin')->nullable();
            $tabla->boolean('activo')->default(true);
            $tabla->timestamps();

            
            $tabla->unique(['nombre', 'temporada']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('torneos');
    }
};
