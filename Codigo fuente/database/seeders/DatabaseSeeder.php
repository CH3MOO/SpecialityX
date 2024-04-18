<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Gain;
use Faker\Provider\UserAgent;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TicketTypeSeeder::class);
        //$this->call(TicketSeeder::class);
        $this->call(StyleSeeder::class);
        $this->call(FrontPageSeeder::class);


        /*comentar para producción*/

        $this->call(CustomerSeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(MaterialSeeder::class);
        $this->call(TaskSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(BudgetSeeder::class);
    }
}
