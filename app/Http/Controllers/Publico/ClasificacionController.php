<?php

namespace App\Http\Controllers\Publico;

use App\Enums\CategoriaTorneo;
use App\Http\Controllers\Controller;
use App\Models\Torneo;
use App\Servicios\ClasificacionServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ClasificacionController extends Controller
{
    public function __invoke(Request $solicitud, ClasificacionServicio $servicio): View
    {
        $torneos = Torneo::orderByDesc('activo')->orderByDesc('fecha_inicio')->get();
        $torneo = $torneos->firstWhere('slug', $solicitud->query('torneo')) ?? $torneos->first();
        $torneosPorCategoria = $torneos->groupBy(fn (Torneo $t) => $t->categoria->value)
            ->mapWithKeys(fn ($lista, $categoria) => [CategoriaTorneo::from($categoria)->etiqueta() => $lista]);
        if (! $torneo) {
            return view('publico.clasificacion', ['torneo' => null, 'torneosPorCategoria' => $torneosPorCategoria]);
        }
        $finalizados = $torneo->partidos()->finalizados()->get();
        $general = $servicio->tabla($torneo, null, $finalizados);
        $tablas = [['clave' => 'todos', 'nombre' => 'Todos', 'filas' => $general]];
        foreach ($servicio->grupos($torneo) as $grupo) {
            $tablas[] = ['clave' => Str::slug($grupo), 'nombre' => $grupo, 'filas' => $servicio->tabla($torneo, $grupo, $finalizados)];
        }
        return view('publico.clasificacion', [
            'torneo' => $torneo,
            'torneosPorCategoria' => $torneosPorCategoria,
            'tablas' => $tablas,
            'ataque' => $servicio->promedios($general, 'favor', true),
            'defensa' => $servicio->promedios($general, 'contra', false),
        ]);
    }
}