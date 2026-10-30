@extends('plantillas.publica')

@section('titulo', 'Clasificación')

@push('scripts')
    <script src="{{ asset('assets/js/pestanas-clasificacion.js') }}"></script>
@endpush

@section('contenido')
<h1 class="pagina__titulo">Clasificación</h1>
@if (! $torneo)
    <p class="vacio">Aún no hay torneos registrados.</p>
@else
    <form method="GET" action="{{ route('clasificacion') }}" class="barra-herramientas">
        <label class="solo-lectores" for="torneo">Torneo</label>
        <select class="seleccion" id="torneo" name="torneo" data-autoenviar style="max-width:360px">
            @foreach ($torneosPorCategoria as $categoria => $lista)
                <optgroup label="{{ $categoria }}">
                    @foreach ($lista as $opcion)
                        <option value="{{ $opcion->slug }}" @selected($opcion->id === $torneo->id)>{{ $opcion->nombre }} · {{ $opcion->temporada }}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
        <noscript><button class="boton boton--primario boton--pequeno" type="submit">Ver</button></noscript>
        <span class="texto-suave texto-pequeno">Victoria = 2 puntos · Derrota = 1 punto · Desempate por diferencia de puntos</span>
    </form>
    <div class="diseno">
        <div data-grupos>
            @if (count($tablas) > 1)
                <div class="pildoras" role="group" aria-label="Grupos">
                    @foreach ($tablas as $tabla)
                        <button type="button" class="pildora {{ $loop->first ? 'es-activo' : '' }}" data-grupo-boton="{{ $tabla['clave'] }}">{{ $tabla['nombre'] }}</button>
                    @endforeach
                </div>
            @endif
            @foreach ($tablas as $tabla)
                <div class="panel panel--sin-relleno tabla-desplazable" data-grupo-tabla="{{ $tabla['clave'] }}" @if (! $loop->first) hidden @endif>
                    @if ($tabla['filas']->isEmpty())
                        <p class="vacio" style="border:0">Este torneo aún no tiene equipos inscritos.</p>
                    @else
                        <table class="tabla">
                            <thead>
                                <tr>
                                    <th>#</th><th>Equipo</th>
                                    <th class="num" title="Partidos jugados">PJ</th>
                                    <th class="num" title="Partidos ganados">PG</th>
                                    <th class="num" title="Partidos perdidos">PP</th>
                                    <th class="num" title="Puntos a favor">PF</th>
                                    <th class="num" title="Puntos en contra">PC</th>
                                    <th class="num" title="Diferencia de puntos">DIF</th>
                                    <th class="num" title="Puntos de clasificación">PTS</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($tabla['filas'] as $fila)
                                <tr>
                                    <td class="posicion">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="celda-equipo">
                                            <x-insignia-equipo :equipo="$fila['equipo']" tamano="s" />
                                            {{ $fila['equipo']->nombre }}
                                        </span>
                                    </td>
                                    <td class="num">{{ $fila['jugados'] }}</td>
                                    <td class="num">{{ $fila['ganados'] }}</td>
                                    <td class="num">{{ $fila['perdidos'] }}</td>
                                    <td class="num">{{ $fila['favor'] }}</td>
                                    <td class="num">{{ $fila['contra'] }}</td>
                                    <td class="num {{ $fila['diferencia'] > 0 ? 'positivo' : ($fila['diferencia'] < 0 ? 'negativo' : '') }}">{{ $fila['diferencia'] > 0 ? '+' : '' }}{{ $fila['diferencia'] }}</td>
                                    <td class="num puntos" @if ($fila['ajuste'] !== 0) title="Incluye un ajuste de {{ $fila['ajuste'] }} punto(s)" @endif>{{ $fila['puntos'] }}@if ($fila['ajuste'] !== 0)*@endif</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            @endforeach
        </div>
        <aside class="diseno__lateral">
            @foreach ([['Mejor ataque', $ataque, 'PF por partido'], ['Mejor defensa', $defensa, 'PC por partido']] as [$titulo, $lista, $leyenda])
                <section class="caja">
                    <h3 class="caja__titulo">{{ $titulo }}</h3>
                    @if ($lista->isEmpty())
                        <p class="caja__vacia">Aún no hay partidos finalizados.</p>
                    @else
                        <table class="tabla tabla--compacta">
                            <thead><tr><th>#</th><th>Equipo</th><th class="num">{{ $leyenda }}</th></tr></thead>
                            <tbody>
                            @foreach ($lista as $item)
                                <tr>
                                    <td class="posicion">{{ $loop->iteration }}</td>
                                    <td><span class="celda-equipo"><x-insignia-equipo :equipo="$item['equipo']" tamano="s" /> {{ $item['equipo']->nombre }}</span></td>
                                    <td class="num puntos">{{ number_format($item['valor'], 1) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </section>
            @endforeach
        </aside>
    </div>
@endif
@endsection