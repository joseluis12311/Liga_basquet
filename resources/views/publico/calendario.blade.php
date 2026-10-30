@extends('plantillas.publica')

@section('titulo', 'Calendario')

@section('contenido')
<h1 class="pagina__titulo">Calendario</h1>
<div class="navegacion-mes">
    <a class="tira-fechas__flecha" href="{{ route('calendario', ['mes' => $anterior]) }}" aria-label="Mes anterior"><i class="bi bi-chevron-left"></i></a>
    <h2>{{ ucfirst($mes->translatedFormat('F Y')) }}</h2>
    <a class="tira-fechas__flecha" href="{{ route('calendario', ['mes' => $siguiente]) }}" aria-label="Mes siguiente"><i class="bi bi-chevron-right"></i></a>
    @unless ($mes->isSameMonth(today()))
        <a class="boton boton--contorno boton--pequeno" href="{{ route('calendario') }}">Ir al mes actual</a>
    @endunless
</div>
@forelse ($dias as $fecha => $partidos)
    <section class="dia-calendario">
        <h3 class="dia-calendario__titulo">{{ ucfirst(\Illuminate\Support\Carbon::parse($fecha)->translatedFormat('l d \d\e F')) }}</h3>
        <div class="rejilla-partidos">
            @foreach ($partidos as $partido)
                <x-tarjeta-partido :partido="$partido" />
            @endforeach
        </div>
    </section>
@empty
    <p class="vacio">No hay partidos programados en este mes.</p>
@endforelse
@endsection