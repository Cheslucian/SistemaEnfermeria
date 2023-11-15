<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear registro para el administrador
        User::create([
            'usuario' => 'Administrador',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin123'),
            'ci' => '8038256',
            'role' => 'admin',
            'imagen' => 'ruta/public/img',
            'nombres' => 'Elmer Dennis',
            'primerApellido' => 'Velasquez',
            'segundoApellido' => 'Pinto',
            'fechaNacimiento' => '1987-07-28',
            'sexo' => 'M',
            'direccion' => 'Cochabamba-Cercado',
            'celular' => '59179968398',
        ]);

        // Crear registro para el paciente
        User::create([
            'usuario' => 'Paciente',
            'email' => 'paciente@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('paciente123'),
            'role' => 'paciente',
            'imagen' => 'ruta/imagen_paciente.png',
            'nombres' => 'Elmer Dennis',
            'primerApellido' => 'Velasquez',
            'segundoApellido' => 'Pinto',
            'ci' => '8038256',
            'fechaNacimiento' => '1987-07-28',
            'sexo' => 'F',
            'direccion' => 'Cochabamba-Cercado',
            'celular' => '59179968398',
        ]);

        // Crear registro para la enfermera
        User::create([
            'usuario' => 'Enfermera',
            'email' => 'enfermera@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('enfermera123'),
            'role' => 'enfermera',
            'imagen' => 'ruta/imagen_enfermera.png',
            'nombres' => 'Marisabel',
            'primerApellido' => 'Mamani',
            'segundoApellido' => 'Fernandez',
            'ci' => '12345678',
            'fechaNacimiento' => '1988-08-08',
            'sexo' => 'F',
            'direccion' => 'Dirección Enfermera',
            'celular' => '59179968398',
        ]);

        User::factory()
            ->count(50)
            ->state(['role' => 'paciente'])
            ->create();
}
}
