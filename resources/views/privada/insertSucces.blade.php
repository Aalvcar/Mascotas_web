@extends('layouts.privada')

@section('titulo', 'Título de la Página')

@section('contenido')
    @auth
    <H2>{{ $nombre_usuario }} creaste una mascota correctamente.</H2>
    <h3>El id de la mascota es {{$mascota_id}}. Antonio Álvarez Cárdenas</h3>
    <br>
    
    <a href="{{ route('formmascotaAAC') }}">Volver al formulario</a><br><br>
    
    

        <A href="{{ route('zonapublica') }}">Ve a la zona pública</A><BR>
        <A href="{{ route('logout') }}">Cierra sesión.</A></BR>
    @endauth

    @endsection