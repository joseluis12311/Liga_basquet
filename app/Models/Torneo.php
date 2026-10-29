<?php

namespace App\Models;

use App\Enums\CategoriaTorneo;
use App\Models\Concerns\GeneraSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Torneo extends Model
{
    use GeneraSlug;

    protected $table = 'torneos';
    protected $fillable = ['nombre', 'categoria', 'temporada', 'fecha_inicio', 'fecha_fin', 'activo'];
    protected $casts = [
        'categoria' => CategoriaTorneo::class,
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean',
    ];

    public function equipos(): BelongsToMany
    {
        return $this->belongsToMany(Equipo::class, 'equipo_torneo')
            ->withPivot(['grupo', 'ajuste_puntos'])
            ->withTimestamps();
    }

    public function partidos(): HasMany
    {
        return $this->hasMany(Partido::class);
    }

    public function scopeActivos(Builder $consulta): Builder
    {
        return $consulta->where('activo', true);
    }

    public function textoParaSlug(): string
    {
        return "{$this->nombre} {$this->temporada}";
    }
}