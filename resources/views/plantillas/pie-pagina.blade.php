<footer class="pie">    
    <div class="pie__interior">        
        <span>&copy; {{ date('Y') }} {{ config('app.name') }} · Proyecto académico</span>        
        <nav aria-label="Pie de página">            
            <a href="{{ route('partidos.index') }}">Partidos</a>            
            <a href="{{ route('clasificacion') }}">Clasificación</a>            
            <a href="{{ route('calendario') }}">Calendario</a>            
            @guest <a href="{{ route('registro') }}">Crear cuenta</a> @endguest
        </nav>    
    </div>
</footer>