<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $fillable=[
        'nombre',
        'precio_unitario',
        'observaciones',
    ];

    public function budgetmaterials(){
        return $this->hasMany(BudgetMaterial::class);
    }
}
