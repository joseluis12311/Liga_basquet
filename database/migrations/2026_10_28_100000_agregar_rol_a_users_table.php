<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $tabla) {

            $tabla->string('rol', 20)->default('usuario')->after('password')->index();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $tabla) {
            $tabla->dropIndex(['rol']);
            $tabla->dropColumn('rol');
        });
    }
};
