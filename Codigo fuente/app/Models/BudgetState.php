<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetState extends Model
{
    use HasFactory;
    protected $fillable=[
        'nombre',
        'descripcion'
    ];


    public function budget(){
        return $this->belongsTo(Budget::class);
    }
}
