<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>    
    <meta charset="utf-8">    
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <meta name="robots" content="noindex, nofollow">    
    <title>@yield('titulo', 'Panel') · Administración</title>    
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logos/icono.svg') }}">    
    <link rel="preconnect" href="https://fonts.googleapis.com">    
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>    
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,700;0,800;1,800&family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">    
    <link href="{{ asset('assets/css/tema.css') }}" rel="stylesheet">    
    <link href="{{ asset('assets/css/plantillas.css') }}" rel="stylesheet">    
    <link href="{{ asset('assets/css/componentes.css') }}" rel="stylesheet">    
    <link href="{{ asset('assets/css/admin.css') }}" rel="stylesheet">    
    @stack('estilos')
</head>
<body>
@php    
    $menu = [        
        ['ruta' => 'admin.panel',               'texto' => 'Resumen',       'icono' => 'bi-speedometer2', 'activo' => 'admin.panel'],        
        ['ruta' => 'admin.equipos.index',       'texto' => 'Equipos',       'icono' => 'bi-shield-shaded', 'activo' => 'admin.equipos.*'],        
        ['ruta' => 'admin.jugadores.index',     'texto' => 'Jugadores',     'icono' => 'bi-people-fill',   'activo' => 'admin.jugadores.*'],        
        ['ruta' => 'admin.torneos.index',       'texto' => 'Torneos',       'icono' => 'bi-trophy',        'activo' => 'admin.torneos.*'],        
        ['ruta' => 'admin.partidos.index',      'texto' => 'Partidos',      'icono' => 'bi-dribbble',      'activo' => 'admin.partidos.*'],        
        ['ruta' => 'admin.clasificacion.index', 'texto' => 'Clasificación', 'icono' => 'bi-bar-chart-line','activo' => 'admin.clasificacion.*'],        
        ['ruta' => 'admin.noticias.index',      'texto' => 'Noticias',      'icono' => 'bi-newspaper',     'activo' => 'admin.noticias.*'],
    ];
@endphp
<div class="admin">    
    <aside class="admin__lateral">        
        <div class="admin__marca">            
            <a href="{{ route('admin.panel') }}" class="marca">                
                <img class="marca__icono" src="{{ asset('assets/img/logos/icono.svg') }}" alt="">                
                <span class="marca__texto"><span>Liga</span><span>Admin</span></span>            
            </a>            
            <small>{{ auth()->user()->name }}</small>        
        </div>        
        <nav class="admin__menu" aria-label="Administración">            
            @foreach ($menu as $item)                
                @if (Route::has($item['ruta']))                    
                    <a href="{{ route($item['ruta']) }}" class="{{ request()->routeIs($item['activo']) ? 'es-activo' : '' }}">                        
                        <i class="bi {{ $item['icono'] }}"></i> {{ $item['texto'] }}                    
                    </a>                
                @endif            
            @endforeach        
        </nav>        
        <div class="admin__pie">            
            <a href="{{ route('inicio') }}"><i class="bi bi-box-arrow-up-right"></i> Ver el sitio</a>            
            <form method="POST" action="{{ route('salir') }}">                
                @csrf                
                <button type="submit"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</button>            
            </form>        
        </div>    
    </aside>
    <div class="admin__contenido">        
        <header class="admin__cabecera">            
            <h1>@yield('encabezado')</h1>            
            <div>@yield('acciones')</div>        
        </header>        
        @foreach (['exito' => 'exito', 'error' => 'error'] as $clave => $tipo)            
            @if (session($clave))                
                <div class="alerta alerta--{{ $tipo }}" role="alert">                    
                    <span>{{ session($clave) }}</span>                    
                    <button type="button" class="alerta__cerrar" aria-label="Cerrar">&times;</button>                
                </div>            
            @endif        
        @endforeach        
        @yield('contenido')    
    </div>
</div>
<script src="{{ asset('assets/js/principal.js') }}"></script>
<script src="{{ asset('assets/js/acciones-admin.js') }}"></script>
@stack('scripts')
</body>
</html>