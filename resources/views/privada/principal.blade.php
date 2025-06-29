@extends('layouts.privada')

@section('titulo', 'Título de la Página')

@section('contenido')
    @auth
    <H2>Bienvenido {{ Auth::user()->name}} a la página principal de la zona PRIVADA.</H2>
    <br>

    <h3>Mis Mascotas</h3>
    <a href="{{ route('formmascotaAAC') }}">Añadir mascota nueva</a><br><br>

    @if ($errors->any())
    <div style="color: red;">
        <H3>Se ha producido un error:</H3>
        @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    @if (session('success'))
    <div style="color: green;">
        {{ session('success') }}
    </div>
    @endif

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
                <th>Convertir</th>
                <th>Borrar</th>
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
                    <form action="{{ route('cambiarpublica') }}" method="post">
                        @csrf
                        <button name="cambio" value="{{ $mascota->id }}">
                            Cambiar a {{ $mascota->publica === 'Si' ? 'privada' : 'pública' }}
                        </button>
                    </form>

                </td>
                <td>
                    <form action="{{ route('eliminar') }}" method="post">
                    @csrf
                        <button name="borrar" value="{{ $mascota->id }}">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <A href="{{ route('zonapublica') }}">Ve a la zona pública</A><BR>
    <A href="{{ route('logout') }}">Cierra sesión.</A></BR>
    @endauth

    @endsection