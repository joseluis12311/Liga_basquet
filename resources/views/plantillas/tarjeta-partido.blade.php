@props(['partido'])
@php    
    $local = $partido->equipoLocal;    
    $visitante = $partido->equipoVisitante;    
    $ganador = $partido->ladoGanador();
@endphp
<article class="partido" data-estado="{{ $partido->estado->value }}" data-categoria="{{ $partido->torneo->categoria->value }}">    
    <div class="partido__estado {{ $partido->estaEnVivo() ? 'es-envivo' : '' }}">        
        @if ($partido->estaEnVivo())            
            En vivo        
        @elseif ($partido->estaFinalizado())            
            Final
        @else            
            <strong>{{ $partido->fecha_hora->format('H:i') }}</strong>        
        @endif    
    </div>    
    <div>        
        <p class="partido__fase">{{ $partido->fase ?: $partido->torneo->nombre }}</p>        
        <div class="partido__equipo {{ $ganador === 'local' ? 'es-ganador' : '' }} {{ $ganador === 'visitante' ? 'es-perdedor' : '' }}">            
            <x-insignia-equipo :equipo="$local" tamano="s" />            
            <span class="partido__nombre">{{ $local->nombre }}</span>            
            <span class="partido__puntos">{{ $partido->tieneMarcador() ? $partido->puntos_local : '' }}</span>        
        </div>        
        <div class="partido__equipo {{ $ganador === 'visitante' ? 'es-ganador' : '' }} {{ $ganador === 'local' ? 'es-perdedor' : '' }}">            
            <x-insignia-equipo :equipo="$visitante" tamano="s" />            
            <span class="partido__nombre">{{ $visitante->nombre }}</span>            
            <span class="partido__puntos">{{ $partido->tieneMarcador() ? $partido->puntos_visitante : '' }}</span>        
        </div>    
    </div>    
    <a href="{{ route('partidos.show', $partido) }}" class="partido__mas" aria-label="Detalles: {{ $local->nombre }} contra {{ $visitante->nombre }}">Detalles</a>
</article>