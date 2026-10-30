<?php

namespace App\Http\Controllers\Publico;

use App\Enums\CategoriaTorneo;
use App\Http\Controllers\Controller;
use App\Models\Partido;
use App\Models\Torneo;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class PartidoController extends Controller
{
    public function index(Request $solicitud): View
    {
        $fecha = $this->leerFecha($solicitud->query('fecha'));
        $partidos = Partido::with(['torneo', 'equipoLocal', 'equipoVisitante'])
            ->enFecha($fecha)
            ->orderBy('fecha_hora')
            ->get();
        $categorias = Torneo::query()->distinct()->pluck('categoria')
            ->map(fn ($categoria) => $categoria instanceof CategoriaTorneo ? $categoria : CategoriaTorneo::from($categoria))
            ->values();
        return view('publico.partidos', [
            'fecha' => $fecha,
            'dias' => collect(range(-3, 6))->map(fn ($desplazamiento) => $fecha->copy()->addDays($desplazamiento)),
            'anterior' => $fecha->copy()->subDays(7)->toDateString(),
            'siguiente' => $fecha->copy()->addDays(7)->toDateString(),
            'grupos' => $partidos->groupBy('torneo_id'),
            'categorias' => $categorias,
            'enVivo' => $partidos->filter(fn (Partido $partido) => $partido->estaEnVivo())->count(),
        ]);
    }

    public function show(Partido $partido): View
    {
        $partido->load([
            'torneo',
            'equipoLocal.jugadores' => fn ($consulta) => $consulta->orderBy('dorsal'),
            'equipoVisitante.jugadores' => fn ($consulta) => $consulta->orderBy('dorsal'),
        ]);
        return view('publico.partido', compact('partido'));
    }

    private function leerFecha(?string $valor): Carbon
    {
        if ($valor && preg_match('/^\d{4}-\d{2}-\d{2}$/', $valor)) {
            try {
                return Carbon::createFromFormat('Y-m-d', $valor)->startOfDay();
            } catch (\Throwable) {
            }
        }
        return today();
    }
}