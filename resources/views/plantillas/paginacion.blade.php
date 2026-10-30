@if ($paginator->hasPages())    
    <nav class="paginacion" role="navigation" aria-label="Paginación">        
        @if ($paginator->onFirstPage())            
            <span class="paginacion__item esta-desactivado" aria-hidden="true">&lsaquo;</span>        
        @else
            <a class="paginacion__item" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Anterior">&lsaquo;</a>        
        @endif        
        @foreach ($elements as $elemento)            
            @if (is_string($elemento))                
                <span class="paginacion__item esta-desactivado">{{ $elemento }}</span>            
            @endif            
            @if (is_array($elemento))                
                @foreach ($elemento as $pagina => $url)                    
                    @if ($pagina == $paginator->currentPage())                        
                        <span class="paginacion__item es-activo" aria-current="page">{{ $pagina }}</span>                    
                    @else                        
                        <a class="paginacion__item" href="{{ $url }}">{{ $pagina }}</a>                    
                    @endif                
                @endforeach            
            @endif        
        @endforeach        
        @if ($paginator->hasMorePages())            
            <a class="paginacion__item" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Siguiente">&rsaquo;</a>        
        @else            
            <span class="paginacion__item esta-desactivado" aria-hidden="true">&rsaquo;</span>        
        @endif    
    </nav>
@endif