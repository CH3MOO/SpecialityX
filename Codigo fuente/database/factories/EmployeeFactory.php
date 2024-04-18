<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre_completo'=>$this->faker->name(),
            'cedula'=>$this->faker->uuid(),
            'celular'=>$this->faker->phoneNumber(),
            'fecha_nacimiento'=>Carbon::today(),
            'domicilio'=>$this->faker->address(),
            'telefono_alternativo'=>$this->faker->phoneNumber(),
            'uniforme'=>rand(0,1)

        ];
    }
}
