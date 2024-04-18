<?php

namespace Database\Seeders;

use App\Models\TicketType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TicketType::create([
            'name'=>'Sugerencia',
            'description'=>'Representa una sugerencial del usario'
        ]);

        TicketType::create([
            'name'=>'Queja',
            'description'=>'Representa una queja del usuario'
        ]);

        TicketType::create([
            'name'=>'Cambio de datos',
            'description'=>'Representa una solicitud para cambio de datos'
        ]);

        TicketType::create([
            'name'=>'Retiro de ganancias',
            'description'=>'Representa una solicitud de retiro de ganancias'
        ]);
    }
}
