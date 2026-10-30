@props(['equipo', 'tamano' => 'm'])
@if ($equipo->url_escudo)    
    <img class="insignia insignia--{{ $tamano }}" src="{{ $equipo->url_escudo }}" alt="" loading="lazy">
@else    
    <span class="insignia insignia--{{ $tamano }}" style="--tono: {{ $equipo->tono }}" aria-hidden="true">{{ $tamano === 's' ? mb_substr($equipo->sigla, 0, 1) : $equipo->sigla }}</span>
@endif