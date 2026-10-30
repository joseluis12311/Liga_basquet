<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class ActualizarEquipoRequest extends GuardarEquipoRequest
{
    public function rules(): array
    {
        $equipo = $this->route('equipo');
        return array_merge(parent::rules(), [
            'nombre' => ['required', 'string', 'max:100', Rule::unique('equipos', 'nombre')->ignore($equipo)],
            'sigla' => ['required', 'string', 'size:3', 'alpha', Rule::unique('equipos', 'sigla')->ignore($equipo)],
        ]);
    }
}