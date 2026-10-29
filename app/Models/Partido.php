<?php

namespace App\Models;

use App\Enums\EstadoPartido;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Partido extends Model
{
    protected $table = 'partidos';
    protected $fillable = [
        'torneo_id', 'equipo_local_id', 'equipo_visitante_id', 'fecha_hora',
        'fase', 'sede', 'estado', 'puntos_local', 'puntos_visitante',
    ];
    protected $casts = [
        'fecha_hora' => 'datetime',
        'estado' => EstadoPartido::class,
    ];

    public function torneo(): BelongsTo
    {
        return $this->belongsTo(Torneo::class);
    }

    public function equipoLocal(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'equipo_local_id');
    }

    public function equipoVisitante(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'equipo_visitante_id');
    }

    public function scopeFinalizados(Builder $consulta): Builder
    {
        return $consulta->where('estado', EstadoPartido::Finalizado->value);
    }

    public function scopeEnVivo(Builder $consulta): Builder
    {
        return $consulta->where('estado', EstadoPartido::EnVivo->value);
    }

    public function scopeProgramados(Builder $consulta): Builder
    {
        return $consulta->where('estado', EstadoPartido::Programado->value);
    }

    public function scopeEnFecha(Builder $consulta, $fecha): Builder
    {
        return $consulta->whereDate('fecha_hora', $fecha);
    }

    public function estaFinalizado(): bool
    {
        return $this->estado === EstadoPartido::Finalizado;
    }

    public function estaEnVivo(): bool
    {
        return $this->estado === EstadoPartido::EnVivo;
    }

    public function tieneMarcador(): bool
    {
        return $this->estado !== EstadoPartido::Programado
            && $this->puntos_local !== null
            && $this->puntos_visitante !== null;
    }

    public function ladoGanador(): ?string
    {
        if (! $this->estaFinalizado() || ! $this->tieneMarcador()) {
            return null;
        }
        return $this->puntos_local > $this->puntos_visitante ? 'local' : 'visitante';
    }
}