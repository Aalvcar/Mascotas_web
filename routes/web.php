<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MascotaControllerAAC;
use App\Models\MascotaAAC;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Ruta a la zona pública (simplemente accediendo a / vía GET)
Route::get('/', function () {

    $mascotas = MascotaAAC::where('publica', 'Si')->get();
    return view('principal', ['mascotasAAC' => $mascotas]);
})->name('zonapublica');

//Ruta a la zona privada (simplemente accediendo a /zonaprivada vía GET)
Route::get('/zonaprivada', function () {

    // De aqui obtengo el susuario autenticado
    $mascotasPrivadas = Auth::user()->mascotas; //Listado de mascotas del usuario autenticado 
    return view('privada.principal', ['mascotasAAC' => $mascotasPrivadas]);
})->middleware('auth')->name('zonaprivada');

//Creamos una ruta nombrada (formlogin) tipo GET a '/login' que mostrará el formulario
Route::get('/login', [LoginController::class, 'mostrarFormularioLoginAAC'])->name('formlogin');
//Creamos una ruta nombrada (login) tipo POST a '/login' que procesará el formulario
Route::post('/login', [LoginController::class, 'loginAAC'])->name('login');
//Creamos una ruta nombrada (logout) tipo POST a '/logout' que cerrará la sesión
Route::get('/logout', [LoginController::class, 'logoutAAC'])->name('logout');


//Ruta para mostrar el formulario de añadir mascota llamada formmascotaAAC
Route::get('/mascota/nueva', [MascotaControllerAAC::class, 'formularioInsert'])->middleware('auth')->name('formmascotaAAC');
//Ruta para llamar al controlador para validar los datos e insertar la mascota
Route::post('/mascota/nueva', [MascotaControllerAAC::class, 'insertMascota'])->middleware('auth')->name('nuevamascotaAAC');

// Ruta para los votos de las mascotas
Route::post('/mascota/votada', [MascotaControllerAAC::class, 'votoMascota'])->middleware('auth')->name('votarmascota');

// Ruta para cambiar a privada/publica
Route::post('/mascota/cambiar', [MascotaControllerAAC::class, 'cambiarPublica'])->middleware('auth')->name('cambiarpublica');

// Ruta para eliminar la mascota
Route::post('/mascota/eliminar', [MascotaControllerAAC::class, 'eliminar'])->middleware('auth')->name('eliminar');
