<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      User::create([
        'sponsor_code'=>strtoupper(str_replace(' ','',str_replace(':','',str_replace('-','',Str::random(5).Carbon::now())))) ,
        'name'=> 'Martín',
        'last_name'=>'Admin',
        'email'=>'martin@correo.com',
        'email_verified_at' => now(),
        'password'=>bcrypt('12345678'),

        ])->assignRole('Administrador');

      User::create([
            'sponsor_code'=>strtoupper(str_replace(' ','',str_replace(':','',str_replace('-','',Str::random(5).Carbon::now())))) ,
            'name'=> 'Administrador',
            'last_name'=>'admin',
            'email'=>'admin@correo.com',
            'email_verified_at' => now(),
            'password'=>bcrypt('12345678'),

        ])->assignRole('Administrador');


    }

}
