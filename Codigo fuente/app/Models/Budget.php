<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;
    protected $fillable=[
        'fecha',
        'customer_id',
        'state_id',
        'locacion',
        'descripcion',
        'total',
        'total_materiales',
        'total_rh',
        'pagos',
    ];


    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function state(){
        return $this->belongsTo(State::class);
    }
    public function budgetmaterials(){
        return $this->hasMany(BudgetMaterial::class);
    }

    public function budgetemployees(){
        return $this->hasMany(BudgetEmployee::class);
    }

    public function budgettaskemployee(){
        return $this->hasMany(budgettaskemployee::class);
    }
    public function budgetpayments(){
        return $this->hasMany(BudgetPayment::class);
    }
    public function budgettracings(){
        return $this->hasMany(budgettracing::class);
    }
}
