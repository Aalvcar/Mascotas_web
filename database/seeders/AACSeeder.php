<?php

namespace Database\Seeders;

use App\Models\MascotaAAC;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


use App\Models\User;


class AACSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Uso firstOrCreate para evitar duplicados, lo que hace la función es buscar el email del usuario, si devuelve null la busqueda, entonces crea el registro.
        // Si lo encuentra no lo crea y devuelve la instancia de ese registros. Es una funcion que esta en vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php

        $user1 = User::firstOrCreate(
            ['email' => 'AAC1@email.AAC'], // Buscamos por el campo 'email' que en teoría debe ser único
            [
                'name' => 'AAC1',
                'email_verified_at' => now(),  // De paso valido el email, para no tener que hacerlo luego 
                'password' => Hash::make('AAC1'),
            ]
        );

        MascotaAAC::firstOrCreate(
            ['nombre' => 'Shrek', 'user_id' => $user1->id], // Asignamos usamos el ID real, para no meterlo de forma manual. Puede que haya saltos, o que no lo conozcamos
            [
                'descripcion' => 'Es un siames, muy desconfiado, peludo y con un ojo menos.',
                'tipo' => 'Gato',
                'publica' => 'Si',
            ]
        );
        MascotaAAC::firstOrCreate(
            ['nombre' => 'Sebastian',  'user_id' => $user1->id], 
            [
                'descripcion' => 'Un conejo bastante feo, pero en la cazuela seguro que tiene mejor cara.',
                'tipo' => 'Conejo',
                'publica' => 'No',
            ]
        );

        // Creo el segunsdo usuario y obtengo su ID
        $user2 = User::firstOrCreate(
            ['email' => 'AAC2@email.AAC'],
            [
                'name' => 'AAC2',
                'email_verified_at' => now(),
                'password' => Hash::make('AAC2'),
            ]
        );

        MascotaAAC::firstOrCreate(
            ['nombre' => 'Pena', 'user_id' => $user2->id],
            [
                'descripcion' => 'Es un dragon, pero ni vuela, ni asusta ni escupe fuego, en realidad da pena.',
                'tipo' => 'Dragon',
                'publica' => 'Si',
            ]
        );
        MascotaAAC::firstOrCreate(
            ['nombre' => 'Rata', 'user_id' => $user2->id],
            [
                'descripcion' => 'Es un hamster, pero feo. Tanto que parece una rata, pero una rata fea.',
                'tipo' => 'Hamster',
                'publica' => 'No',
            ]
        );
    }
}


/*$mascota = MascotaAAC::firstOrNew([
    'nombre' => 'Shrek',
    'descripcion' => 'Es un siamés, muy desconfiado, peludo y con un ojo menos.',
    'tipo' => 'Gato',
    'publica' => 'Si',
    'user_id' => 2,
]);
}

if (!$mascota->exists) {
    $mascota->save();
    
Método con firstOrNew(), que lo hace igual, pero carga en una variable en memoria lo que encuentra y decidimos si guardarlo o no.
    */

/*Para rellenar campos con datos aleatorios podemos usar la clase Faker:

$faker = Faker::create();
        // Generamos 10 registros de mascotas con datos aleatorios
        foreach (range(1, 10) as $index) {
            Mascota::create([
                'nombre' => $faker->word(), // Nombre aleatorio
                'descripcion' => $faker->sentence(), // Descripción aleatoria, ni idea de lo que puede salir, pero se puede mirar en el repo de github
                'tipo' => $faker->randomElement(['Perro', 'Gato', 'Pájaro']), // Tipo aleatorio
                'publica' => $faker->randomElement(['Si', 'No']), // Publica o no
                'megusta' => $faker->numberBetween(0, 100), // Me gusta aleatorio, se puede dejar vacío si no lo hemos incluido en el fillable, por defecto 0
                'user_id' => $faker->numberBetween(1, 10), // Usuario aleatorio, supongamos que hay 10 usuarios
            ]);
        }
*/