<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class GuardarEquipoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('sigla')) {
            $this->merge(['sigla' => Str::upper($this->input('sigla'))]);
        }
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:100', 'unique:equipos,nombre'],
            'sigla' => ['required', 'string', 'size:3', 'alpha', 'unique:equipos,sigla'],
            'ciudad' => ['required', 'string', 'max:100'],
            'entrenador' => ['nullable', 'string', 'max:100'],
            'anio_fundacion' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'escudo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}