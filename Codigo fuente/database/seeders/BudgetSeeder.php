<?php

namespace Database\Seeders;

use App\Models\Budget;
use Database\Factories\BudgetFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Budget::factory(15)->create();
    }
}
