<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre'=>$this->faker->name(),
            'razon_social'=>$this->faker->name(),
            'rut'=>$this->faker->uuid(),
            'direccion'=>$this->faker->address(),
            'telefono'=>$this->faker->phoneNumber(),

        ];




    }
}
