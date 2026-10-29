<?php

namespace App\Models;

use App\Models\Concerns\GeneraSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipo extends Model
{
    use GeneraSlug;

    protected $table = 'equipos';
    protected $fillable = ['nombre', 'sigla', 'ciudad', 'entrenador', 'anio_fundacion', 'escudo'];

    public function jugadores(): HasMany
    {
        return $this->hasMany(Jugador::class);
    }

    public function torneos(): BelongsToMany
    {
        return $this->belongsToMany(Torneo::class, 'equipo_torneo')
            ->withPivot(['grupo', 'ajuste_puntos'])
            ->withTimestamps();
    }

    public function partidos(): Builder
    {
        return Partido::query()->where(
            fn ($consulta) => $consulta
                ->where('equipo_local_id', $this->id)
                ->orWhere('equipo_visitante_id', $this->id)
        );
    }

    protected function urlEscudo(): Attribute
    {
        return Attribute::get(fn () => $this->escudo ? asset('assets/img/escudos/' . $this->escudo) : null);
    }

    protected function tono(): Attribute
    {
        return Attribute::get(fn () => (($this->id ?? 0) * 47) % 360);
    }
}