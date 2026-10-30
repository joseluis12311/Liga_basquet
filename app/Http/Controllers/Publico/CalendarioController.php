<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\Partido;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class CalendarioController extends Controller
{
    public function __invoke(Request $solicitud): View
    {
        $mes = $this->leerMes($solicitud->query('mes'));
        $dias = Partido::with(['torneo', 'equipoLocal', 'equipoVisitante'])
            ->whereBetween('fecha_hora', [$mes->copy()->startOfMonth(), $mes->copy()->endOfMonth()])
            ->orderBy('fecha_hora')
            ->get()
            ->groupBy(fn (Partido $partido) => $partido->fecha_hora->toDateString());
        return view('publico.calendario', [
            'mes' => $mes,
            'anterior' => $mes->copy()->subMonth()->format('Y-m'),
            'siguiente' => $mes->copy()->addMonth()->format('Y-m'),
            'dias' => $dias,
        ]);
    }

    private function leerMes(?string $valor): Carbon
    {
        if ($valor && preg_match('/^\d{4}-\d{2}$/', $valor)) {
            try {
                return Carbon::createFromFormat('Y-m-d', $valor . '-01')->startOfDay();
            } catch (\Throwable) {
            }
        }
        return today()->startOfMonth();
    }
}