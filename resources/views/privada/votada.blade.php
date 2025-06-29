@extends('layouts.privada')

@section('titulo', 'Título de la Página')

@section('contenido')
    @auth
    <H2>{{ $nombre_usuario }} has votado por la mascota {{ $nombre_mascota }} con el id {{ $mascota_id }} .</H2>
    <br>
    <h3>Su dueño {{ $mascota_propiet }} se ha puesto muy contento!.</h3><br><br>

    <A href="{{ route('zonapublica') }}">Ve a la zona pública</A><BR><br>

    @endauth

    @endsection