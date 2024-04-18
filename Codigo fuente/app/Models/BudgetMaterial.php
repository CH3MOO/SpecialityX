<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetMaterial extends Model
{
    use HasFactory;
    protected $fillable=[
        'budget_id',
        'material_id',
        'cantidad',
        'total',
        'precio_promo'
    ];

    public function budget(){
        return $this->belongsTo(Budget::class);
    }
    public function material(){
        return $this->belongsTo(Material::class);
    }






}
