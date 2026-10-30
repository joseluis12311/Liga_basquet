@extends('plantillas.publica')

@section('titulo', $partido->equipoLocal->nombre . ' vs ' . $partido->equipoVisitante->nombre)

@section('contenido')
@php
    $local = $partido->equipoLocal;
    $visitante = $partido->equipoVisitante;
    $ganador = $partido->ladoGanador();
@endphp
<a class="enlace-mas" style="margin-bottom:1rem" href="{{ route('partidos.index', ['fecha' => $partido->fecha_hora->toDateString()]) }}">
    <i class="bi bi-arrow-left"></i> Volver a partidos</a>
<section class="panel marcador">
    <p class="marcador__meta">
        {{ $partido->torneo->nombre }}
        @if ($partido->fase) · {{ $partido->fase }} @endif
        · {{ ucfirst($partido->fecha_hora->translatedFormat('l d \d\e F, H:i')) }}
        @if ($partido->sede) · {{ $partido->sede }} @endif
    </p>
    <div class="marcador__rejilla">
        <div class="marcador__equipo {{ $ganador === 'visitante' ? 'es-perdedor' : '' }}">
            <x-insignia-equipo :equipo="$local" tamano="l" />
            <span>{{ $local->nombre }}</span>
        </div>
        @if ($partido->tieneMarcador())
            <div class="marcador__puntos">
                <span class="{{ $ganador === 'local' ? 'es-ganador' : '' }}">{{ $partido->puntos_local }}</span>
                <span class="texto-suave">–</span>
                <span class="{{ $ganador === 'visitante' ? 'es-ganador' : '' }}">{{ $partido->puntos_visitante }}</span>
            </div>
        @else
            <div class="marcador__hora">{{ $partido->fecha_hora->format('H:i') }}</div>
        @endif
        <div class="marcador__equipo {{ $ganador === 'local' ? 'es-perdedor' : '' }}">
            <x-insignia-equipo :equipo="$visitante" tamano="l" />
            <span>{{ $visitante->nombre }}</span>
        </div>
    </div>
    <p style="margin:1.3rem 0 0">
        @if ($partido->estaEnVivo()) <span class="etiqueta etiqueta--envivo">● En vivo</span>
        @elseif ($partido->estaFinalizado()) <span class="etiqueta etiqueta--ok">Final</span>
        @else <span class="etiqueta etiqueta--azul">Programado</span>
        @endif
    </p>
</section>
<div class="plantillas-equipos">
    @foreach ([$local, $visitante] as $equipo)
        <section class="caja">
            <h3 class="caja__titulo">Plantel · {{ $equipo->nombre }}</h3>
            @if ($equipo->jugadores->isEmpty())
                <p class="caja__vacia">Este equipo aún no tiene jugadores registrados.</p>
            @else
                <table class="tabla tabla--compacta">
                    <thead><tr><th class="num">#</th><th>Jugador</th><th>Posición</th></tr></thead>
                    <tbody>
                    @foreach ($equipo->jugadores as $jugador)
                        <tr>
                            <td class="num puntos">{{ $jugador->dorsal }}</td>
                            <td>{{ $jugador->nombre_completo }}</td>
                            <td class="texto-suave">{{ $jugador->posicion->etiqueta() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </section>
    @endforeach
</div>
@endsection