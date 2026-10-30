<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use App\Models\Partido;
use App\Models\Torneo;
use App\Servicios\ClasificacionServicio;
use Illuminate\View\View;

class InicioController extends Controller
{
    public function __invoke(ClasificacionServicio $clasificacion): View
    {
        $relaciones = ['torneo', 'equipoLocal', 'equipoVisitante'];
        $noticias = Noticia::publicadas()->latest('publicada_en')->take(4)->get();
        $partidos = Partido::with($relaciones)->enFecha(today())->orderBy('fecha_hora')->get();
        $tituloPartidos = 'Partidos de hoy';
        if ($partidos->isEmpty()) {
            $partidos = Partido::with($relaciones)->programados()
                ->where('fecha_hora', '>=', now())->orderBy('fecha_hora')->take(4)->get();
            $tituloPartidos = 'Próximos partidos';
        }
        $resumenes = Torneo::activos()->orderByDesc('fecha_inicio')->take(2)->get()
            ->map(fn (Torneo $torneo) => [
                'torneo' => $torneo,
                'filas' => $clasificacion->tabla($torneo)->take(5),
            ]);
        return view('publico.inicio', compact('noticias', 'partidos', 'tituloPartidos', 'resumenes'));
    }
}