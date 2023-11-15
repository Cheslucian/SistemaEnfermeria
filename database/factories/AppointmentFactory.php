<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-1 years', 'now');
        $scheduled_date = $date->format('Y-m-d');
        $scheduled_time = $date->format('H:i:s');
        $types = ['Inyectable', 'Curaciones', 'Primeros Axilios'];
        $enfermeraIds = User::enfermeras()->pluck('id');
        $patientIds = User::patients()->pluck('id');
        $statuses = ['Atendida', 'Cancelada'];

        return [
            'scheduled_date' => $scheduled_date,
            'scheduled_time' => $scheduled_time,
            'type' => $this->faker->randomElement($types),
            'description' => $this->faker->sentence(5),
            'enfermera_id' => $this->faker->randomElement($enfermeraIds),
            'patient_id' => $this->faker->randomElement($patientIds),
            'specialty_id' => $this->faker->numberBetween(1,7),
            'status' => $this->faker->randomElement($statuses)
        ];
    }
}
