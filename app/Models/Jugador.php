<?php

namespace App\Models;

use App\Enums\PosicionJugador;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jugador extends Model
{
    protected $table = 'jugadores';
    protected $fillable = [
        'equipo_id', 'nombres', 'apellidos', 'dorsal',
        'posicion', 'estatura_cm', 'fecha_nacimiento',
    ];
    protected $casts = [
        'posicion' => PosicionJugador::class,
        'fecha_nacimiento' => 'date',
    ];

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }

    protected function nombreCompleto(): Attribute
    {
        return Attribute::get(fn () => "{$this->nombres} {$this->apellidos}");
    }
}