@extends('layouts.principal')

@section('titulo', 'Página Principal')

@section('contenido')
    @auth

        <h1>Ya has iniciado sesión</h1>
        <a href="{{ route('zonaprivada') }}">Ir a zona privada</a>

    @endauth

    @guest
        <h1>Iniciar Sesión</h1>
        @if ($errors->any())
            <div style="color: red;">
                <H2>ERRORES:</H2>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario de inicio de sesión -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"><BR>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password"><BR>
            <input type="submit" value="Login">
        </form>
    @endguest

    @endsection