<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable=[
        'nombre',
        'razon_social',
        'rut',
        'direccion',
        'telefono',
        'comentarios',
    ];
}
