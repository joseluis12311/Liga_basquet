<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\Noticia;
use App\Models\Partido;
use App\Models\Torneo;
use App\Models\User;
use Illuminate\View\View;

class PanelController extends Controller
{
    public function __invoke(): View
    {
        $relaciones = ['equipoLocal', 'equipoVisitante'];
        return view('admin.panel', [
            'tarjetas' => [
                ['texto' => 'Equipos', 'valor' => Equipo::count(), 'icono' => 'bi-shield-shaded', 'ruta' => 'admin.equipos.index'],
                ['texto' => 'Jugadores', 'valor' => Jugador::count(), 'icono' => 'bi-people-fill', 'ruta' => 'admin.jugadores.index'],
                ['texto' => 'Torneos', 'valor' => Torneo::count(), 'icono' => 'bi-trophy', 'ruta' => 'admin.torneos.index'],
                ['texto' => 'Partidos', 'valor' => Partido::count(), 'icono' => 'bi-dribbble', 'ruta' => 'admin.partidos.index'],
                ['texto' => 'Noticias', 'valor' => Noticia::count(), 'icono' => 'bi-newspaper', 'ruta' => 'admin.noticias.index'],
            ],
            'enVivo' => Partido::enVivo()->count(),
            'borradores' => Noticia::whereNull('publicada_en')->count(),
            'usuarios' => User::count(),
            'proximos' => Partido::with($relaciones)->programados()->where('fecha_hora', '>=', now())
                ->orderBy('fecha_hora')->take(5)->get(),
            'recientes' => Partido::with($relaciones)->finalizados()->latest('fecha_hora')->take(5)->get(),
        ]);
    }
}