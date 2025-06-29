<?php

namespace App\Http\Controllers;

use App\Models\MascotaAAC;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

class MascotaControllerAAC extends Controller
{
    public function formularioInsert()
    {
        return view('privada.formmascotaAAC');
    }


    public function insertMascota(Request $request)
    {
        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser un texto válido.',
            'nombre.max' => 'El nombre no puede tener más de 50 caracteres.',
            'nombre.min' => 'El nombre debe tener al menos 4 caracteres.',
            
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.string' => 'La descripción debe ser un texto válido.',
            'descripcion.max' => 'La descripción no puede tener más de 250 caracteres.',
            
            'publica.required' => 'Es necesario especificar si la mascota es pública o no.',
            'publica.string' => 'La visibilidad debe ser un valor de texto.',
            'publica.in' => 'La visibilidad debe ser "Si" o "No".',
            
            'tipo.required' => 'Es necesario seleccionar un tipo de mascota.',
            'tipo.string' => 'El tipo debe ser un texto válido.',
            'tipo.in' => 'El tipo de mascota seleccionado no es válido. Debes elegir entre Perro, Gato, Pájaro, Dragón, Conejo, Hamster, Tortuga, Pez o Serpiente.',
        ];

        // return print_r($request->all(), true); // esta línea se eliminará en siguientes pasos
        $datosvalidados = $request->validate([
            'nombre' => 'required|string|max:50|min:4',
            'descripcion' => 'required|string|max:250',
            'publica' => 'required|string|in:Si,No',
            'tipo' => 'required|string|in:Perro,Gato,Pájaro,Dragón,Conejo,Hamster,Tortuga,Pez,Serpiente'
        ],$mensajes);

        $user = auth()->user();

        if ($user) {
            $datosvalidados['user_id'] = $user->id;
            $mascota = MascotaAAC::create($datosvalidados); // uso el metodo create de laravel que rellena los campos fillable

            // Si esta logueado y ha pasado las validaciones devuelve la vista y le pasa el ide de mascota y el nombre de usuario
            return view('privada.insertSucces', [
                'mascota_id' => $mascota->id,
                'nombre_usuario' => $user->name,
            ]);
        } // En caso de que el usuario no esté autenticado lo redirijo al formulario de login
        return redirect()->route('login');
    }


    public function votoMascota(Request $request)
    {
        // Valido la entrada del id para asegurar que no se ha modificado
        $idValido = $request->validate([
            'id' => 'required|int|min:1|exists:mascotas,id'
        ], [
            'id.required' => 'El id es obligatorio.',
            'id.int' => 'El id debe ser un número entero.',
            'id.min' => 'El id debe ser mayor o igual a 1.',
            'id.exists' => 'El id debe existir en la base de datos.'
        ]);

        // Obtener la mascota por su ID
        $mascota = MascotaAAC::find($idValido['id']);
        $usuarioActual = auth()->user();

        if ($mascota->user_id !== $usuarioActual->id) {
            $mascota->megusta++;
            $mascota->save();
            return view('privada.votada', [
                'mascota_id' => $mascota->id,
                'nombre_mascota' => $mascota->nombre,
                'nombre_usuario' => $usuarioActual->name,
                'mascota_propiet' => $mascota->user->name,
            ]);
        } else {
            // $error = 'No puedes votar a tus propias mascotas, tramposo!'; // He intentado sacarlo con view (view('zonapublica', ['error' => $error]);) pero da error, asi que he tenido que buscar otras maneras.
            // return redirect()->route('zonapublica')->with('error', 'No puedes votar a tus propias mascotas, tramposo!');
            // Al final mejor asi, lo cargo en la variable $errors global, que **se resetea con cada peticion**.
            return back()->withErrors('No puedes votar a tus propias mascotas, tramposo!');
        }
    }


    public function cambiarPublica(Request $request)
    {
        // Definir mensajes de error personalizados, me gusta mas asi y luego pasarle la variable
        $messages = [
            'cambio.required' => 'Es necesario seleccionar una mascota para cambiar su visibilidad.',
            'cambio.exists' => 'La mascota que intentas modificar no existe.',
            'cambio.int' => 'El ID de la mascota debe ser un número entero.',
        ];

        // Validar con los mensajes personalizados la entrada del id para asegurar que no se ha modificado
        $idValido = $request->validate([
            'cambio' => 'required|int|min:1|exists:mascotas,id',
        ], $messages);  // Aquí pasamos los mensajes personalizados que he creado

        // Obtener la mascota por su ID
        $mascota = MascotaAAC::find($idValido['cambio']);

        $usuarioActual = auth()->user();
        if ($mascota->user_id !== $usuarioActual->id) {
            // Si no pertenece al usuario, redirigir con un mensaje de error
            return back()->withErrors('No tienes permiso para modificar esta mascota.');
        }

        if ($mascota) {
            $mascota->publica = $mascota->publica === 'Si' ? 'No' : 'Si';
            $mascota->save();
            return back()->with('success', 'La visibilidad de la mascota "' . $mascota->nombre . '" ha sido actualizada.');;
        } else {
            return back()->withErrors('Mascota no encontrada');
        }
    }

    public function eliminar(Request $request)
    {
        $messages = [
            'borrar.required' => 'Es necesario seleccionar una mascota para eliminar.',
            'borrar.exists' => 'La mascota que intentas borrar no existe.',
            'borrar.int' => 'El ID de la mascota debe ser un número entero.',
        ];

        // Validar con los mensajes personalizados la entrada del id para asegurar que no se ha modificado
        $idValido = $request->validate([
            'borrar' => 'required|int|min:1|exists:mascotas,id',
        ], $messages);

        // Obtener la mascota por su ID
        $mascota = MascotaAAC::find($idValido['borrar']);

        $usuarioActual = auth()->user();
        if ($mascota->user_id !== $usuarioActual->id) {
            // Si no pertenece al usuario, redirigir con un mensaje de error
            return back()->withErrors('No tienes permiso para borrar esta mascota.');
        }
        // Si existe pues la borro con delete y mando un mensaje de exito, sino mando un mensaje de error.
        if ($mascota) {
            $mascota->delete();
            return back()->with('success', 'La mascota "' . $mascota->nombre . '" ha sido borrada.');;
        } else {
            return back()->withErrors('Mascota no encontrada');
        }
    }
}


/*Reglas comunes de validación para usar 'campo.regla':
required: El campo es obligatorio.
string: El campo debe ser una cadena de texto.
min: El campo debe tener un valor mínimo (se usa con números o cadenas).
max: El campo debe tener un valor máximo.
email: El campo debe ser un correo electrónico válido.
int: El campo debe ser un número entero.
exists: El valor debe existir en la base de datos (se usa para verificar que el valor existe en una columna de una tabla).
unique: El campo debe ser único en la base de datos.
date: El campo debe ser una fecha válida.
confirmed: Se usa para comparar dos campos (por ejemplo, para confirmar la contraseña)*/