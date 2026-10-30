<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ActualizarJugadorRequest;
use App\Http\Requests\Admin\GuardarJugadorRequest;
use App\Models\Equipo;
use App\Models\Jugador;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JugadorController extends Controller
{
    public function index(Request $solicitud): View
    {
        $equipoId = $solicitud->integer('equipo') ?: null;
        $jugadores = Jugador::with('equipo')
            ->when($equipoId, fn ($consulta) => $consulta->where('equipo_id', $equipoId))
            ->orderBy('equipo_id')->orderBy('dorsal')
            ->paginate(15)
            ->withQueryString();
        return view('admin.jugadores.indice', [
            'jugadores' => $jugadores,
            'equipos' => Equipo::orderBy('nombre')->get(),
            'equipoId' => $equipoId,
        ]);
    }

    public function create(Request $solicitud): View
    {
        return view('admin.jugadores.crear', [
            'jugador' => new Jugador(['equipo_id' => $solicitud->integer('equipo') ?: null]),
            'equipos' => Equipo::orderBy('nombre')->get(),
        ]);
    }

    public function store(GuardarJugadorRequest $solicitud): RedirectResponse
    {
        $jugador = Jugador::create($solicitud->validated());
        return redirect()->route('admin.jugadores.index', ['equipo' => $jugador->equipo_id])
            ->with('exito', 'Jugador agregado.');
    }

    public function edit(Jugador $jugador): View
    {
        return view('admin.jugadores.editar', [
            'jugador' => $jugador,
            'equipos' => Equipo::orderBy('nombre')->get(),
        ]);
    }

    public function update(ActualizarJugadorRequest $solicitud, Jugador $jugador): RedirectResponse
    {
        $jugador->update($solicitud->validated());
        return redirect()->route('admin.jugadores.index', ['equipo' => $jugador->equipo_id])
            ->with('exito', 'Jugador actualizado.');
    }

    public function destroy(Jugador $jugador): RedirectResponse
    {
        $equipoId = $jugador->equipo_id;
        $jugador->delete();
        return redirect()->route('admin.jugadores.index', ['equipo' => $equipoId])
            ->with('exito', 'Jugador eliminado.');
    }
}