<?php

namespace Database\Seeders;

use App\Models\FrontPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FrontPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          FrontPage::create([
            'title'=>'CRM Salud ',
            'description'=>'Está es la imagen de portada. Aquí se puede colocar una descripción o texto informativo.'
          ]);




    }
}
