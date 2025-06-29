@extends('layouts.privada')

@section('titulo', 'Título de la Página')

@section('contenido')

@if ($errors->any())
<H3>Se han producido errores en el formulario:</H3>
<UL>
    @foreach ($errors->all() as $error)
    <LI>{{ $error }}</LI>
    @endforeach
</UL>
@endif

<form action="{{ route('nuevamascotaAAC') }}" method="post">

    @csrf

    <label for="nombre">Nombre de la mascota:</label><br>
    <input type="text" name="nombre" id="nombre"><br><br>

    <label for="descripcion">Descripción de la mascota:</label><br>
    <textarea name="descripcion" id="descripcion" rows="4" cols="60"></textarea><br><br>

    <label for="tipo">Tipo de mascota:</label>
    <select name="tipo" id="tipo">
        <option value="Perro">Perro</option>
        <option value="Gato">Gato</option>
        <option value="Pájaro">Pájaro</option>
        <option value="Dragón">Dragón</option>
        <option value="Conejo">Conejo</option>
        <option value="Hamster">Hamster</option>
        <option value="Tortuga">Tortuga</option>
        <option value="Pez">Pez</option>
        <option value="Serpiente">Serpiente</option>
    </select>
    <br><br>

    <label>¿Mascota pública?</label>
    <input type="radio" name="publica" value="Si" id="publica_si">
    <label for="publica_si">Sí</label>

    <input type="radio" name="publica" value="No" id="publica_no">
    <label for="publica_no">No</label>
    <br><br>

    <button type="submit">Crear!</button>
</form>
@endsection