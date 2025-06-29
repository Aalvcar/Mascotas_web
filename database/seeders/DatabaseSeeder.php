<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        {
            $this->call(AACSeeder::class); //Cuando llamo a 'php artisan db:seed' se carga esta llamada a mi Seeder personalizado, puedo hacer simplemente 'php artisan db:seed XYZSeeder', pero así solo tenemos que hacer una llamada para cargarlo todo si hubiera mas seeders.
        }

    }
}
