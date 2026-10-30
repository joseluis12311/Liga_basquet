@php    
    $enlaces = [
        ['url' => route('inicio'),           'texto' => 'Inicio',        'icono' => 'bi-house-door',     'activo' => 'inicio'],        
        ['url' => route('partidos.index'),   'texto' => 'Partidos',      'icono' => 'bi-dribbble',       'activo' => 'partidos.*'],        
        ['url' => route('inicio') . '#noticias', 'texto' => 'Noticias',  'icono' => 'bi-newspaper',      'activo' => 'noticias.*'],        
        ['url' => route('clasificacion'),    'texto' => 'Clasificación', 'icono' => 'bi-bar-chart-line', 'activo' => 'clasificacion'],        
        ['url' => route('calendario'),       'texto' => 'Calendario',    'icono' => 'bi-calendar3',      'activo' => 'calendario'],    ];
@endphp
<header class="encabezado">    
    <div class="encabezado__interior">        
        <a href="{{ route('inicio') }}" class="marca" aria-label="{{ config('app.name') }} - Inicio">            
            <img class="marca__icono" src="{{ asset('assets/img/logos/icono.svg') }}" alt="">            
            <span class="marca__texto"><span>Liga</span><span>Básquet</span></span>        
        </a>        
        <nav class="navegacion" data-navegacion aria-label="Principal">            
            @foreach ($enlaces as $enlace)                
                <a href="{{ $enlace['url'] }}" class="navegacion__enlace {{ request()->routeIs($enlace['activo']) ? 'es-activo' : '' }}">                    
                    <i class="bi {{ $enlace['icono'] }}"></i> {{ $enlace['texto'] }}                
                </a>            
            @endforeach        
        </nav>        
        <div class="acciones-encabezado">            
            @guest                
                <a href="{{ route('login') }}" class="boton boton--primario boton--pequeno"><i class="bi bi-person-circle"></i> Iniciar sesión</a>            
            @endguest            
            @auth                
                <div class="menu-usuario" data-desplegable>                    
                    <button type="button" class="boton boton--contorno boton--pequeno" data-desplegable-boton aria-expanded="false" aria-haspopup="true">                        
                        <i class="bi bi-person-circle"></i> {{ \Illuminate\Support\Str::limit(auth()->user()->name, 14) }}
                    </button>                    
                    <div class="menu-usuario__panel" data-desplegable-panel hidden>                        
                        <div class="menu-usuario__datos">                            
                            <strong>{{ auth()->user()->name }}</strong>                            
                            <span class="texto-suave texto-pequeno">{{ auth()->user()->email }}</span>                        
                        </div>                        
                        @if (auth()->user()->esAdministrador() && Route::has('admin.panel'))                            
                            <a href="{{ route('admin.panel') }}"><i class="bi bi-speedometer2"></i> Panel de administración</a>                        
                        @endif                        
                        <form method="POST" action="{{ route('salir') }}">                            
                            @csrf                            
                            <button type="submit"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</button>                        
                        </form>                    
                    </div>                
                </div>            
            @endauth        
        </div>        
        <button type="button" class="boton-menu" data-boton-menu aria-expanded="false" aria-label="Abrir menú"><i class="bi bi-list"></i></button>    
    </div>
</header>