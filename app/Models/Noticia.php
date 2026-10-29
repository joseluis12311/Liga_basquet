<?php

namespace App\Models;

use App\Models\Concerns\GeneraSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Noticia extends Model
{
    use GeneraSlug;

    protected $table = 'noticias';
    protected $fillable = ['autor_id', 'titulo', 'resumen', 'contenido', 'imagen', 'publicada_en'];
    protected $casts = ['publicada_en' => 'datetime'];

    public function textoParaSlug(): string
    {
        return (string) $this->titulo;
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'autor_id');
    }

    public function scopePublicadas(Builder $consulta): Builder
    {
        return $consulta->whereNotNull('publicada_en')->where('publicada_en', '<=', now());
    }

    public function estaPublicada(): bool
    {
        return $this->publicada_en !== null && $this->publicada_en->lte(now());
    }

    protected function urlImagen(): Attribute
    {
        return Attribute::get(fn () => $this->imagen ? asset('assets/img/noticias/' . $this->imagen) : null);
    }

    protected function extracto(): Attribute
    {
        return Attribute::get(fn () => $this->resumen ?: Str::limit(strip_tags($this->contenido), 140));
    }
}