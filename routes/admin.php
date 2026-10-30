<?php

use App\Http\Controllers\Admin\EquipoController;
use App\Http\Controllers\Admin\JugadorController;
use App\Http\Controllers\Admin\PanelController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'solo.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', PanelController::class)->name('panel');
    Route::resource('equipos', EquipoController::class)->parameters(['equipos' => 'equipo'])->except('show');
    Route::resource('jugadores', JugadorController::class)->parameters(['jugadores' => 'jugador'])->except('show');
});