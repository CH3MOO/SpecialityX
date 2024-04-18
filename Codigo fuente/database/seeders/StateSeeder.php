<?php

namespace Database\Seeders;

use App\Models\BudgetState;
use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::create([
            'nombre'=>'Creado',
            'descripcion'=>'creado'
        ]);
        State::create([
            'nombre'=>'Enviado',
            'descripcion'=>'Enviado'
        ]);
        State::create([
            'nombre'=>'Aceptado',
            'descripcion'=>'Aceptado'
        ]);
        State::create([
            'nombre'=>'No aceptado',
            'descripcion'=>'No aceptado'
        ]);
        State::create([
            'nombre'=>'Finalizado',
            'descripcion'=>'Finalizado'
        ]);
    }
}
