<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('titulo')</title>
    <link rel="stylesheet" href="{{ asset('styles2.css') }}">
</head>

<body>
    <header>
        <h1>Mi Aplicación de Mascotas</h1>
        <h2>Antonio Álvarez Cárdenas</h2>
        <h3 class="privada">Zona privada</h3>

    </header>

    <main>
        @yield('contenido')
    </main>

    <footer>
        <p>Mi Aplicación de Mascotas. IES Aguadulce 2024/2025</p>
        <p>Todos los derechos reservados.</p>
    </footer>
</body>

</html>