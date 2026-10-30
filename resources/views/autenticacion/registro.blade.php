@extends('plantillas.publica')

@section('titulo', 'Crear cuenta')

@section('contenido')
<div class="tarjeta-acceso">
    <h1>Crear cuenta</h1>
    <p class="texto-suave">Regístrate para entrar a la liga.</p>
    <form method="POST" action="{{ route('registro') }}" novalidate>
        @csrf
        <div class="campo">
            <label class="campo__etiqueta" for="name">Nombre</label>
            <input class="entrada @error('name') es-invalido @enderror" id="name" name="name" value="{{ old('name') }}" autocomplete="name" required autofocus>
            @error('name')<p class="campo__error">{{ $message }}</p>@enderror
        </div>
        <div class="campo">
            <label class="campo__etiqueta" for="email">Correo</label>
            <input class="entrada @error('email') es-invalido @enderror" id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
            @error('email')<p class="campo__error">{{ $message }}</p>@enderror
        </div>
        <div class="campo">
            <label class="campo__etiqueta" for="password">Contraseña (mínimo 8 caracteres)</label>
            <input class="entrada @error('password') es-invalido @enderror" id="password" type="password" name="password" autocomplete="new-password" required>
            @error('password')<p class="campo__error">{{ $message }}</p>@enderror
        </div>
        <div class="campo">
            <label class="campo__etiqueta" for="password_confirmation">Repite la contraseña</label>
            <input class="entrada" id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
        </div>
        <button class="boton boton--primario boton--bloque" type="submit">Crear cuenta</button>
    </form>
    <p class="tarjeta-acceso__pie">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
</div>
@endsection