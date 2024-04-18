<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetPayment extends Model
{
    use HasFactory;
    protected $fillable=[
        'budget_id',
        'fecha',
        'monto_pago',
        'observaciones'
    ];

    public function budget(){
        return $this->belongsTo(Budget::class);
    }











}
