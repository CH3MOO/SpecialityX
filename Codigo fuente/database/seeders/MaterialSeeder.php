<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Material::create([
            'nombre'=>"tabla de madera",
            'precio_unitario'=>150,
            'Observaciones'=>'tabla de madera por metro',
        ]);


        Material::create([
            'nombre'=>"pintuta acrilica",
            'precio_unitario'=>400,
            'Observaciones'=>'bote 4 litros, color',
        ]);

        Material::create([
            'nombre'=>"tubo de cobre 1/2",
            'precio_unitario'=>300,
            'Observaciones'=>'6 metros parede delgada',
        ]);


        Material::create([
            'nombre'=>"Cemento portland",
            'precio_unitario'=>200,
            'Observaciones'=>'bulto 50 kilos',
        ]);


        Material::create([
            'nombre'=>"focos led",
            'precio_unitario'=>45,
            'Observaciones'=>'luz calida, 100lmns',
        ]);
        //Material::factory(40)->create();
    }
}
