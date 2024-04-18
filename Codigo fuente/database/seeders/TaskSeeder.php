<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Task::create([
                'nombre'=>'terapia fisica',
                'precio_hora'=>1500,
        ]);

        Task::create([
            'nombre'=>'colocarción brackers',
            'precio_hora'=>200,
        ]);

        Task::create([
            'nombre'=>'curación',
            'precio_hora'=>400,
        ]);

        Task::create([
            'nombre'=>'cirugía ',
            'precio_hora'=>300,
        ]);
        //Task::factory(60)->create();
    }
}
