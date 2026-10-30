<?php

namespace App\Http\Requests\Admin;

use App\Enums\PosicionJugador;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GuardarJugadorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'equipo_id' => ['required', 'exists:equipos,id'],
            'nombres' => ['required', 'string', 'max:80'],
            'apellidos' => ['required', 'string', 'max:80'],
            'dorsal' => [
                'required', 'integer', 'between:0,99',
                Rule::unique('jugadores', 'dorsal')->where('equipo_id', $this->input('equipo_id')),
            ],
            'posicion' => ['required', Rule::enum(PosicionJugador::class)],
            'estatura_cm' => ['nullable', 'integer', 'between:140,240'],
            'fecha_nacimiento' => ['nullable', 'date', 'before:today'],
        ];
    }
}