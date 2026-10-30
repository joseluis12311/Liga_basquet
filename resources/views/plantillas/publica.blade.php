<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>    
    <meta charset="utf-8">    
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <meta name="theme-color" content="#0b1b33">    
    <title>@yield('titulo', 'Inicio') · {{ config('app.name') }}</title>    
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logos/icono.svg') }}">    
    <link rel="preconnect" href="https://fonts.googleapis.com">    
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>    
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,700;0,800;1,800&family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">    
    <link href="{{ asset('assets/css/tema.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/plantillas.css') }}" rel="stylesheet">    
    <link href="{{ asset('assets/css/componentes.css') }}" rel="stylesheet">    
    @stack('estilos')
</head>
<body>    
    <x-barra-navegacion />    
    @yield('portada')    
    <main class="pagina">        
        @foreach (['exito' => 'exito', 'error' => 'error'] as $clave => $tipo)            
            @if (session($clave))                
                <div class="alerta alerta--{{ $tipo }}" role="alert">                    
                    <span>{{ session($clave) }}</span>                    
                    <button type="button" class="alerta__cerrar" aria-label="Cerrar">&times;</button>                
                </div>            
            @endif        
        @endforeach        
        @yield('contenido')    
    </main>    
    <x-pie-pagina />    
    <script src="{{ asset('assets/js/principal.js') }}"></script>    
    @stack('scripts')
</body>
</html><!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>    
    <meta charset="utf-8">    
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <meta name="theme-color" content="#0b1b33">    
    <title>@yield('titulo', 'Inicio') · {{ config('app.name') }}</title>    
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logos/icono.svg') }}">    
    <link rel="preconnect" href="https://fonts.googleapis.com">    
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>    
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,700;0,800;1,800&family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">    
    <link href="{{ asset('assets/css/tema.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/plantillas.css') }}" rel="stylesheet">    
    <link href="{{ asset('assets/css/componentes.css') }}" rel="stylesheet">    
    @stack('estilos')
</head>
<body>    
    <x-barra-navegacion />    
    @yield('portada')    
    <main class="pagina">        
        @foreach (['exito' => 'exito', 'error' => 'error'] as $clave => $tipo)            
            @if (session($clave))                
                <div class="alerta alerta--{{ $tipo }}" role="alert">                    
                    <span>{{ session($clave) }}</span>                    
                    <button type="button" class="alerta__cerrar" aria-label="Cerrar">&times;</button>                
                </div>            
            @endif        
        @endforeach        
        @yield('contenido')    
    </main>    
    <x-pie-pagina />    
    <script src="{{ asset('assets/js/principal.js') }}"></script>    
    @stack('scripts')
</body>
</html>