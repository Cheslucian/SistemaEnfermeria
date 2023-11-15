<?php

namespace Database\Seeders;

use App\Models\Specialty;
use App\Models\User;
use Illuminate\Database\Seeder;

class SpecialtiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialties = [
            'Neurología',
            'Quirúrgica',
            'Pediatría',
            'Cardiología',
            'Urología',
            'Medicina forense',
            'Dermatología'
        ];

        foreach ($specialties as $specialtyName) {
            $specialty = Specialty::create([
                'nombre' => $specialtyName
            ]);

            // Crear 4 enfermeras para cada especialidad
            $enfermeras = User::factory(4)->state(['role' => 'enfermera'])->create();
            $specialty->users()->attach($enfermeras);

            // Asignar una especialidad a un usuario específico (enfermera)
            $enfermera = User::find(3); // Cambia el ID del usuario según tus necesidades
            $enfermera->specialties()->attach($specialty->id);
        }
    }
}
