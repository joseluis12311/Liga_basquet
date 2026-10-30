<?php

namespace App\Servicios;

use App\Models\Torneo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ClasificacionServicio
{
    private const PUNTOS_VICTORIA = 2;
    private const PUNTOS_DERROTA = 1;

    public function tabla(Torneo $torneo, ?string $grupo = null, ?Collection $partidos = null): Collection
    {
        $filas = [];
        foreach ($torneo->equipos()->orderBy('nombre')->get() as $equipo) {
            if ($grupo !== null && $equipo->pivot->grupo !== $grupo) {
                continue;
            }
            $ajuste = (int) $equipo->pivot->ajuste_puntos;
            $filas[$equipo->id] = [
                'equipo' => $equipo,
                'grupo' => $equipo->pivot->grupo,
                'jugados' => 0, 'ganados' => 0, 'perdidos' => 0,
                'favor' => 0, 'contra' => 0, 'diferencia' => 0,
                'ajuste' => $ajuste,
                'puntos' => $ajuste,
            ];
        }
        $partidos ??= $torneo->partidos()->finalizados()->get();
        foreach ($partidos as $partido) {
            $this->sumar($filas, $partido->equipo_local_id, $partido->puntos_local, $partido->puntos_visitante);
            $this->sumar($filas, $partido->equipo_visitante_id, $partido->puntos_visitante, $partido->puntos_local);
        }
        return collect($filas)
            ->sortBy([['puntos', 'desc'], ['diferencia', 'desc'], ['favor', 'desc']])
            ->values();
    }

    public function grupos(Torneo $torneo): Collection
    {
        return DB::table('equipo_torneo')
            ->where('torneo_id', $torneo->id)
            ->whereNotNull('grupo')
            ->distinct()
            ->orderBy('grupo')
            ->pluck('grupo');
    }

    public function promedios(Collection $tabla, string $campo, bool $descendente, int $limite = 5): Collection
    {
        return $tabla
            ->filter(fn ($fila) => $fila['jugados'] > 0)
            ->map(fn ($fila) => ['equipo' => $fila['equipo'], 'valor' => round($fila[$campo] / $fila['jugados'], 1)])
            ->sortBy('valor', SORT_REGULAR, $descendente)
            ->take($limite)
            ->values();
    }

    private function sumar(array &$filas, int $equipoId, int $anotados, int $recibidos): void
    {
        if (! isset($filas[$equipoId])) {
            return;
        }
        $gano = $anotados > $recibidos;
        $filas[$equipoId]['jugados']++;
        $filas[$equipoId]['ganados'] += $gano ? 1 : 0;
        $filas[$equipoId]['perdidos'] += $gano ? 0 : 1;
        $filas[$equipoId]['favor'] += $anotados;
        $filas[$equipoId]['contra'] += $recibidos;
        $filas[$equipoId]['diferencia'] = $filas[$equipoId]['favor'] - $filas[$equipoId]['contra'];
        $filas[$equipoId]['puntos'] += $gano ? self::PUNTOS_VICTORIA : self::PUNTOS_DERROTA;
    }
}