<?php

namespace App\Http\Controllers\Autenticacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class SesionController extends Controller
{
    public function formulario(): View
    {
        return view('autenticacion.ingresar');
    }

    public function iniciar(Request $solicitud): RedirectResponse
    {
        $credenciales = $solicitud->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credenciales, $solicitud->boolean('recordar'))) {
            $solicitud->session()->regenerate();
            $destino = (Route::has('admin.panel') && Auth::user()->esAdministrador())
                ? route('admin.panel')
                : route('inicio');
            return redirect()->intended($destino);
        }

        return back()
            ->withErrors(['email' => 'El correo o la contraseña no son correctos.'])
            ->onlyInput('email');
    }

    public function cerrar(Request $solicitud): RedirectResponse
    {
        Auth::logout();
        $solicitud->session()->invalidate();
        $solicitud->session()->regenerateToken();
        return redirect()->route('inicio');
    }
}