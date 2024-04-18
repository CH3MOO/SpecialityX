<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetEmployee extends Model
{
    use HasFactory;

    protected $fillable=[
        'budget_id',
        'employee_id',
    ];

    public function budget(){
        return $this->belongsTo(Budget::class);
    }
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
