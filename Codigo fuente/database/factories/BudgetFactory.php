<?php

namespace Database\Factories;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Budget>
 */
class BudgetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'fecha'=>Carbon::today(),
            'customer_id'=>Customer::all()->random()->id,
            'state_id'=>1,
            'locacion'=>'Mexico',
            'descripcion'=>'cualquier cosa'
        ];
    }
}
