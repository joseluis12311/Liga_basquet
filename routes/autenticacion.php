<?php

use App\Http\Controllers\Autenticacion\RegistroController;
use App\Http\Controllers\Autenticacion\SesionController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/ingresar', [SesionController::class, 'formulario'])->name('login');
    Route::post('/ingresar', [SesionController::class, 'iniciar']);
    Route::get('/registro', [RegistroController::class, 'formulario'])->name('registro');
    Route::post('/registro', [RegistroController::class, 'guardar']);
});

Route::post('/salir', [SesionController::class, 'cerrar'])->middleware('auth')->name('salir');