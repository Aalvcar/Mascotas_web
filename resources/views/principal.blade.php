@extends('layouts.principal')

@section('titulo', 'Página Principal')

@section('contenido')
<H2>Bienvenido a la página principal PÚBLICA.</H2>
@auth
Estás autenticado, puedes ir a ...
<A href="{{ route('zonaprivada') }}">tu zona privada</A><BR>
@endauth
@guest
No estás autenticado, por favor ...
<A href="{{ route('formlogin') }}">inicia sesión.</A><BR>
@endguest

@if ($errors->any())
<div style="color: red;">
    <H3>Se ha producido un error:</H3>
    @foreach ($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif


<br>
<table border 1px solid>
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Tipo</th>
            <th>Publica</th>
            <th>Nº Me gustas</th>
            <th>Propietario</th>
            <th>Fecha de creación</th>
            <th>Fecha de actualización</th>
            <th>Votar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mascotasAAC as $mascota)
        <tr>
            <td>{{$mascota->id}}</td>
            <td>{{$mascota->nombre}}</td>
            <td>{{$mascota->descripcion}}</td>
            <td>{{$mascota->tipo}}</td>
            <td>{{$mascota->publica}}</td>
            <td>{{$mascota->megusta}}</td>
            <td>{{$mascota->user->name}}</td>
            <td>{{$mascota->created_at}}</td>
            <td>{{$mascota->updated_at}}</td>
            <td>
                <form action="{{ route('votarmascota') }}" method="post"><input type="hidden" name="id" value="{{$mascota->id}}">
                    @csrf
                    <button>¡Votar!</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection