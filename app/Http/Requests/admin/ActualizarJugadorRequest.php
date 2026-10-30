<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class ActualizarJugadorRequest extends GuardarJugadorRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'dorsal' => [
                'required', 'integer', 'between:0,99',
                Rule::unique('jugadores', 'dorsal')
                    ->where('equipo_id', $this->input('equipo_id'))
                    ->ignore($this->route('jugador')),
            ],
        ]);
    }
}