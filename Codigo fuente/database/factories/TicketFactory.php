<?php

namespace Database\Factories;

use App\Models\TicketType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition()
    {


        $wallets=['Electrum','Bitcoin Core','Bretz','Bitcoin Wallet','Exodus'];
        $status=rand(0,1);
        return [
            'user_id'=>User::all()->random()->id,
            'description'=>$this->faker->paragraph(1),
            'ticket_type_id'=>TicketType::all()->random()->id,
            'status'=>$status,
            'name'=>$this->faker->name(),
            'last_name'=>$this->faker->lastName(),
            'country'=>$this->faker->country(),
            'state'=>$this->faker->word(),
            'city'=>$this->faker->city(),
            'identity_document_name'=>$this->faker->word(),
            'identity_document_number'=>Str::random(10),
            'wallet'=>$wallets[rand(0,4)],
            'phone_number'=>$this->faker->phoneNumber(),
            'email'=>$this->faker->safeEmail(),
            'close_date'=>($status==1)?Carbon::now():null,
        ];
    }
}
