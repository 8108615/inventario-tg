<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();



        $this->call([
            RoleSeeder::class,
            CategoriaAntiguaSeeder::class,
            ProductoAntiguoSeeder::class,
        ]);

        User::create([
            'name' => 'Erick Fernando Morales Gil',
            'email' => 'erick@gmail.com',
            'tipo_documento' => 'cedula de identidad',
            'numero_documento' => '8108615',
            'celular' => '76658531',
            'direccion' => 'Av Cumavi',
            'fecha_nacimiento' => '1991-12-20',
            'genero' => 'Masculino',
            'foto_perfil' => null,
            'estado' => 'Activo',
            'password' => bcrypt('12345678'),
        ])->assignRole('SUPER ADMIN');
    }
}
