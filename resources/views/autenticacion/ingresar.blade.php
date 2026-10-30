@extends('plantillas.publica')

@section('titulo', 'Iniciar sesión')

@section('contenido')
<div class="tarjeta-acceso">
    <h1>Iniciar sesión</h1>
    <p class="texto-suave">Entra para administrar la liga o guardar tus preferencias.</p>
    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf
        <div class="campo">
            <label class="campo__etiqueta" for="email">Correo</label>
            <input class="entrada @error('email') es-invalido @enderror" id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
            @error('email')<p class="campo__error">{{ $message }}</p>@enderror
        </div>
        <div class="campo">
            <label class="campo__etiqueta" for="password">Contraseña</label>
            <input class="entrada @error('password') es-invalido @enderror" id="password" type="password" name="password" autocomplete="current-password" required>
            @error('password')<p class="campo__error">{{ $message }}</p>@enderror
        </div>
        <label class="casilla" style="margin-bottom:1.2rem">
            <input type="checkbox" name="recordar" value="1"> Mantener la sesión iniciada
        </label>
        <button class="boton boton--primario boton--bloque" type="submit">Entrar</button>
    </form>
    <p class="tarjeta-acceso__pie">¿No tienes cuenta? <a href="{{ route('registro') }}">Crea una</a></p>
</div>
@endsection