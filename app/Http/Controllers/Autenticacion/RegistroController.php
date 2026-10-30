<?php

namespace App\Http\Controllers\Autenticacion;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegistroController extends Controller
{
    public function formulario(): View
    {
        return view('autenticacion.registro');
    }

    public function guardar(Request $solicitud): RedirectResponse
    {
        $datos = $solicitud->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $usuario = User::create($datos);
        Auth::login($usuario);
        $solicitud->session()->regenerate();
        return redirect()->route('inicio')->with('exito', '¡Cuenta creada! Bienvenido.');
    }
}