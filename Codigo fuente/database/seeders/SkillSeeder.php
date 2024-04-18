<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Skill::create([
            'nombre'=>'enfermeria',
            'descripcion'=>'cuidados'
        ]);

        Skill::create([
            'nombre'=>'cirujano',
            'descripcion'=>'cirujano partero'
        ]);


        Skill::create([
            'nombre'=>'fisitioterapetura',
            'descripcion'=>'terapia de reabilitación'
        ]);

        Skill::create([
            'nombre'=>'Estomatologia',
            'descripcion'=>'dentista'
        ]);


        Skill::create([
            'nombre'=>'Medigo general',
            'descripcion'=>'consultas'
        ]);
        //Skill::factory(40)->create();
    }
}
