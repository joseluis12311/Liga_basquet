@extends('plantillas.publica')

@section('titulo', 'Inicio')

@section('portada')
    @php
        $urlPortada = file_exists(public_path('assets/img/fondos/portada.jpg')) ? asset('assets/img/fondos/portada.jpg') : null;
    @endphp
    <section class="portada" @if ($urlPortada) style="--imagen: url('{{ $urlPortada }}')" @endif>
        <div class="portada__interior">
            <h1 class="portada__titulo">Toda la liga de básquetbol en un solo lugar</h1>
            <p class="portada__texto">Resultados en vivo, clasificación y noticias de cada torneo, actualizados por la organización.</p>
            <div class="portada__acciones">
                <a class="boton boton--naranja" href="{{ route('partidos.index') }}"><i class="bi bi-dribbble"></i> Ver partidos</a>
                <a class="boton boton--claro" href="{{ route('clasificacion') }}"><i class="bi bi-bar-chart-line"></i> Clasificación</a>
            </div>
        </div>
    </section>
@endsection

@section('contenido')
<section class="seccion">
    <div class="seccion__titulo">
        <h2>{{ $tituloPartidos }}</h2>
        <a class="enlace-mas" href="{{ route('partidos.index') }}">Ver todos <i class="bi bi-arrow-right"></i></a>
    </div>
    @if ($partidos->isEmpty())
        <p class="vacio">No hay partidos programados por el momento.</p>
    @else
        <div class="rejilla-partidos">
            @foreach ($partidos as $partido)
                <x-tarjeta-partido :partido="$partido" />
            @endforeach
        </div>
    @endif
</section>

<div class="diseno seccion">
    <section id="noticias" aria-labelledby="titulo-noticias">
        <div class="seccion__titulo"><h2 id="titulo-noticias">Noticias</h2></div>
        @if ($noticias->isEmpty())
            <p class="vacio">Aún no hay noticias publicadas.</p>
        @else
            <div class="noticias-rejilla">
                @foreach ($noticias as $noticia)
                    <x-tarjeta-noticia :noticia="$noticia" />
                @endforeach
            </div>
        @endif
    </section>
    <aside class="diseno__lateral" aria-label="Clasificación resumida">
        @forelse ($resumenes as $resumen)
            <section class="caja">
                <h3 class="caja__titulo">{{ $resumen['torneo']->nombre }}</h3>
                @if ($resumen['filas']->isEmpty())
                    <p class="caja__vacia">Aún no hay equipos inscritos.</p>
                @else
                    <table class="tabla tabla--compacta">
                        <thead><tr><th>#</th><th>Equipo</th><th class="num">PJ</th><th class="num">PTS</th></tr></thead>
                        <tbody>
                        @foreach ($resumen['filas'] as $fila)
                            <tr>
                                <td class="posicion">{{ $loop->iteration }}</td>
                                <td><span class="celda-equipo"><x-insignia-equipo :equipo="$fila['equipo']" tamano="s" /> {{ $fila['equipo']->sigla }}</span></td>
                                <td class="num">{{ $fila['jugados'] }}</td>
                                <td class="num puntos">{{ $fila['puntos'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </section>
        @empty
            <p class="vacio">Aún no hay torneos activos.</p>
        @endforelse
        <a class="enlace-mas" href="{{ route('clasificacion') }}">Ver clasificación completa <i class="bi bi-arrow-right"></i></a>
    </aside>
</div>
@endsection