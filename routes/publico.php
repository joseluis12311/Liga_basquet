<?php

use App\Http\Controllers\Publico\CalendarioController;
use App\Http\Controllers\Publico\ClasificacionController;
use App\Http\Controllers\Publico\InicioController;
use App\Http\Controllers\Publico\NoticiaController;
use App\Http\Controllers\Publico\PartidoController;
use Illuminate\Support\Facades\Route;

Route::get('/', InicioController::class)->name('inicio');
Route::get('/partidos', [PartidoController::class, 'index'])->name('partidos.index');
Route::get('/partidos/{partido}', [PartidoController::class, 'show'])->name('partidos.show');
Route::get('/clasificacion', ClasificacionController::class)->name('clasificacion');
Route::get('/calendario', CalendarioController::class)->name('calendario');
Route::get('/noticias/{noticia:slug}', [NoticiaController::class, 'show'])->name('noticias.show');