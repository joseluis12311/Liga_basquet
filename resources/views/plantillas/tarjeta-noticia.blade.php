@props(['noticia'])
<a href="{{ route('noticias.show', $noticia) }}" class="noticia-tarjeta">    
    @if ($noticia->url_imagen)
        <img class="noticia-tarjeta__imagen" src="{{ $noticia->url_imagen }}" alt="" loading="lazy">    
    @else        
        <span class="noticia-tarjeta__imagen portada-{{ $noticia->id % 4 }}"></span>    
    @endif    
    <span class="noticia-tarjeta__cuerpo">        
        <span class="noticia-tarjeta__fecha">{{ $noticia->publicada_en?->translatedFormat('d M Y') }}</span>        
        <span class="noticia-tarjeta__titulo">{{ $noticia->titulo }}</span>        
        <span class="noticia-tarjeta__resumen">{{ \Illuminate\Support\Str::limit($noticia->extracto, 90) }}</span>    
    </span>
</a>