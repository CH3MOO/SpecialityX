<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        /*
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
*/
$sponsor_code= strtoupper(str_replace(' ','',str_replace(':','',str_replace('-','',Str::random(5).Carbon::now())))) ;

        return [
            'sponsor_code'=>$sponsor_code,
            'name'=>$this->faker->name(),
            'last_name'=>$this->faker->lastName(),
            //'country'=>$this->faker->country(),
            //'state'=>$this->faker->word(),
            //'city'=>$this->faker->city(),
            //'identity_document_name'=>$this->faker->word(5),
            //'identity_document_number'=>$this->faker->word(12),
            //'wallet'=>$this->faker->word(10),
            //'phone_number'=>$this->faker->phoneNumber(),
            'email' => fake()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt("12345678"),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
