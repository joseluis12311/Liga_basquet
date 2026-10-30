<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ActualizarEquipoRequest;
use App\Http\Requests\Admin\GuardarEquipoRequest;
use App\Models\Equipo;
use App\Servicios\ImagenServicio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EquipoController extends Controller
{
    public function __construct(private ImagenServicio $imagenes)
    {
    }

    public function index(Request $solicitud): View
    {
        $buscar = trim((string) $solicitud->query('buscar'));
        $equipos = Equipo::withCount('jugadores')
            ->when($buscar !== '', fn ($consulta) => $consulta->where(
                fn ($q) => $q->where('nombre', 'like', "%{$buscar}%")->orWhere('sigla', 'like', "%{$buscar}%")
            ))
            ->orderBy('nombre')
            ->paginate(12)
            ->withQueryString();
        return view('admin.equipos.indice', compact('equipos', 'buscar'));
    }

    public function create(): View
    {
        return view('admin.equipos.crear', ['equipo' => new Equipo()]);
    }

    public function store(GuardarEquipoRequest $solicitud): RedirectResponse
    {
        $datos = $solicitud->safe()->except('escudo');
        if ($solicitud->hasFile('escudo')) {
            $datos['escudo'] = $this->imagenes->guardar($solicitud->file('escudo'), 'escudos');
        }
        Equipo::create($datos);
        return redirect()->route('admin.equipos.index')->with('exito', 'Equipo creado.');
    }

    public function edit(Equipo $equipo): View
    {
        return view('admin.equipos.editar', compact('equipo'));
    }

    public function update(ActualizarEquipoRequest $solicitud, Equipo $equipo): RedirectResponse
    {
        $datos = $solicitud->safe()->except('escudo');
        if ($solicitud->hasFile('escudo')) {
            $this->imagenes->eliminar($equipo->escudo, 'escudos');
            $datos['escudo'] = $this->imagenes->guardar($solicitud->file('escudo'), 'escudos');
        }
        $equipo->update($datos);
        return redirect()->route('admin.equipos.index')->with('exito', 'Equipo actualizado.');
    }

    public function destroy(Equipo $equipo): RedirectResponse
    {
        if ($equipo->partidos()->exists()) {
            return back()->with('error', 'No se puede eliminar: el equipo tiene partidos registrados.');
        }
        $this->imagenes->eliminar($equipo->escudo, 'escudos');
        $equipo->delete();
        return redirect()->route('admin.equipos.index')->with('exito', 'Equipo eliminado.');
    }
}