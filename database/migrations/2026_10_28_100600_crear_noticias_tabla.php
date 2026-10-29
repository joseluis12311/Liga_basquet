<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('noticias', function (Blueprint $tabla) {
            $tabla->id();
          
            $tabla->foreignId('autor_id')->nullable()->constrained('users')->nullOnDelete();
            $tabla->string('titulo', 150);
            $tabla->string('slug', 170)->unique();
            $tabla->string('resumen', 255)->nullable();
            $tabla->longText('contenido');
            $tabla->string('imagen')->nullable();                    
            $tabla->timestamp('publicada_en')->nullable()->index();  
            $tabla->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
